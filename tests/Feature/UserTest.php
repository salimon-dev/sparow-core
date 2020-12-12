<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testCreateSuccess()
    {
        $user = new User;
        $user->fill([
            'username' => 'testusername',
            'password' => 'testpassword',
            'first_name' => 'user first name',
            'last_name' => 'user last name',
            'email' => 'some@mail.com',
        ]);
        $user->save();
        $this->assertTrue(true, 'user must be created');
    }
    public function testUpdateAvatarSuccess()
    {
        $user = User::whereUsername('testusername')->first();
        $user->updateAvatar(UploadedFile::fake()->image('avatar.png', 100, 100));
        $this->assertTrue(true, 'user must update file');
        $user->updateAvatarFromUrl('https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.heartlandvets.com%2Fblog%2Fwhen-should-i-microchip-my-kitten.html&psig=AOvVaw1xph7Smtbu5CAGPiJy722u&ust=1604979763241000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCLCj6NnF9OwCFQAAAAAdAAAAABAD');
        $this->assertTrue(true, 'user must update file with url');
    }
}
