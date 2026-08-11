<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    public function getHeading(): string
    {
        return 'Registrasi Akun Admin';
    }

    public function getSubheading(): HtmlString|string|null
    {
        return new HtmlString(
            '<p class="text-sm text-gray-500 mb-4" style="line-height: 1.5;">Halaman ini khusus untuk pendaftaran Admin. Jika Anda adalah Pemilik, mintalah link undangan dari Admin.</p>'.
            '<a href="'.url('/login').'"
                class="inline-flex items-center gap-1 text-sm
                    text-gray-500 hover:text-gray-700
                    transition-colors duration-200">
                ← Kembali ke Login
            </a>'
        );
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): User
    {
        $user = parent::handleRegistration($data);

        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user->assignRole($role);

        return $user;
    }
}
