<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // Navegación: ícono, etiquetas, grupo y orden
    protected static ?string $navigationIcon   = 'heroicon-o-user';
    protected static ?string $navigationLabel  = 'Usuarios';
    protected static ?string $pluralLabel      = 'Usuarios';
    protected static ?string $navigationGroup  = 'Seguridad & Usuarios';
    protected static ?int    $navigationSort   = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Generado automáticamente al crear
                Hidden::make('codigo'),

                TextInput::make('name')
                    ->label('Nombre completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('identificacion')
                    ->label('Identificación')
                    ->required()
                    ->maxLength(255),

                TextInput::make('establecimiento')
                    ->label('Nombre del comercio')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->required()
                    ->maxLength(255),

                TextInput::make('direccion')
                    ->label('Dirección')
                    ->required()
                    ->maxLength(255),

                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'admin' => 'Administrador',
                        'user'  => 'Usuario',
                    ])
                    ->required(),

                Hidden::make('password_temporal'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('identificacion')
                    ->label('Identificación')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('establecimiento')
                    ->label('Comercio')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('direccion')
                    ->label('Dirección')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Rol')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('password_temporal')
                    ->label('Clave temporal')
                    ->colors([
                        'secondary' => fn ($state): bool => !$state,
                        'success'   => fn ($state): bool => (bool) $state,
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
