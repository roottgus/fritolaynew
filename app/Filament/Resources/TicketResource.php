<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    // Conservamos tu ícono original
    protected static ?string $navigationIcon  = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Tickets';
    protected static ?string $pluralLabel     = 'Tickets';

    // Agrupación y orden en el sidebar
    protected static ?string $navigationGroup = 'Soporte';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('subject')
                    ->label('Asunto')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'new'         => 'Nuevo',
                        'in_progress' => 'En Progreso',
                        'resolved'    => 'Resuelto',
                        'closed'      => 'Cerrado',
                    ])
                    ->default('new')
                    ->required(),

                Select::make('priority')
                    ->label('Prioridad')
                    ->options([
                        'low'    => 'Baja',
                        'medium' => 'Media',
                        'high'   => 'Alta',
                    ])
                    ->default('medium')
                    ->required(),

                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->nullable(),

                Repeater::make('messages')
                    ->relationship()
                    ->label('Mensajes')
                    ->schema([
                        Textarea::make('body')
                            ->label('Contenido')
                            ->required()
                            ->rows(3),
                    ])
                    ->afterCreate(function ($state, $record) {
                        event(new \App\Events\TicketMessageCreated($record));
                    })
                    ->columns(1)
                    ->createItemButtonLabel('Añadir mensaje'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->enum([
                        'new'         => 'Nuevo',
                        'in_progress' => 'En Progreso',
                        'resolved'    => 'Resuelto',
                        'closed'      => 'Cerrado',
                    ])
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'danger'  => 'closed',
                    ]),

                BadgeColumn::make('priority')
                    ->label('Prioridad')
                    ->enum([
                        'low'    => 'Baja',
                        'medium' => 'Media',
                        'high'   => 'Alta',
                    ])
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger'  => 'high',
                    ]),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filtrar por Estado')
                    ->options([
                        'new'         => 'Nuevo',
                        'in_progress' => 'En Progreso',
                        'resolved'    => 'Resuelto',
                        'closed'      => 'Cerrado',
                    ]),

                SelectFilter::make('priority')
                    ->label('Filtrar por Prioridad')
                    ->options([
                        'low'    => 'Baja',
                        'medium' => 'Media',
                        'high'   => 'Alta',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit'   => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
