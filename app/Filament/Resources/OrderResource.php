<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    // Conservamos tu ícono y etiquetas originales
    protected static ?string $navigationIcon   = 'heroicon-o-receipt-refund';
    protected static ?string $navigationLabel  = 'Pedidos';
    protected static ?string $pluralLabel      = 'Pedidos';

    // Agrupación y orden en el sidebar
    protected static ?string $navigationGroup  = 'Ventas';
    protected static ?int    $navigationSort   = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('user_id')
                    ->label('ID Usuario')
                    ->required(),

                \Filament\Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->numeric()
                    ->required(),

                \Filament\Forms\Components\TextInput::make('status')
                    ->label('Estado')
                    ->required(),

                \Filament\Forms\Components\TextInput::make('origin')
                    ->label('Origen')
                    ->required(),

                \Filament\Forms\Components\Textarea::make('items')
                    ->label('Artículos (JSON)')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->sortable(),

                Tables\Columns\TextColumn::make('origin')
                    ->label('Origen')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
