<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\NewUserCredentials;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /** @var string */
    protected string $tempPassword;

    /**
     * Genera los datos antes de crear el registro.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1) Código aleatorio
        $data['codigo'] = Str::upper(Str::random(6));

        // 2) Contraseña temporal
        $this->tempPassword = Str::random(8);
        $data['password'] = Hash::make($this->tempPassword);
        $data['password_temporal'] = $this->tempPassword;

        return $data;
    }

    /**
     * Crea el registro y luego notifica al usuario.
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Crea el usuario utilizando la lógica base
        $record = parent::handleRecordCreation($data);

        // Envía notificación con credenciales temporales
        $record->notify(
            new NewUserCredentials($record, $this->tempPassword)
        );

        return $record;
    }
}
