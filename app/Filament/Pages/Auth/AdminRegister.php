<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Http\Responses\RegistrationResponse;
use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminRegister extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
            Select::make('role')
                ->label('Daftar Sebagai')
                ->options([
                    'admin' => 'Admin',
                    'pemilik' => 'Pemilik',
                ])
                ->default('pemilik')
                ->required(),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = User::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        $role = Role::firstOrCreate([
            'name'       => $data['role'],
            'guard_name' => 'web',
        ]);

        $user->syncRoles([$role]);

        return $user;
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        $this->handleRegistration($data);

        Auth::logout();

        $this->redirect(url('/login'));

        return null;
    }

    public function getLoginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label('Sudah punya akun? Login di sini')
            ->url(url('/login'));
    }
}