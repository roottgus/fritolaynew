<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    // Conservamos tus íconos y etiquetas originales:
    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Anuncios';
    protected static ?string $pluralLabel     = 'Anuncios';

    // Agrupación y orden en el menú:
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('icon')
                    ->label('Icono')
                    ->options([
                        'fas fa-star'           => 'Estrella',
                        'fas fa-bell'           => 'Campana',
                        'fas fa-heart'          => 'Corazón',
                        'fas fa-clipboard-list' => 'Lista',
                        'fas fa-box'            => 'Caja',
                    ])
                    ->searchable()
                    ->required()
                    ->helperText('Selecciona un ícono de la lista.'),

                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Textarea::make('text')
                    ->label('Descripción')
                    ->required(),

                Toggle::make('active')
                    ->label('Activo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BooleanColumn::make('active')
                    ->label('Activo'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit'   => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
