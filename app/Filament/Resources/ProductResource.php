<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // Conservamos tu ícono y etiquetas originales en español
    protected static ?string $navigationIcon   = 'heroicon-o-cube';
    protected static ?string $navigationLabel  = 'Productos';
    protected static ?string $pluralLabel      = 'Productos';

    // Agrupación y orden en el sidebar
    protected static ?string $navigationGroup  = 'Catálogo';
    protected static ?int    $navigationSort   = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Código')
                    ->required(),

                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                TextInput::make('price')
                    ->label('Precio')
                    ->prefix('COP')
                    ->numeric()
                    ->required(),

                FileUpload::make('image')
                    ->label('Imagen')
                    ->disk('public')
                    ->directory('products')
                    ->image()
                    ->required(),

                Select::make('category')
                    ->label('Categoría')
                    ->options([
                        'Detodito'   => 'Detodito',
                        'Doritos'    => 'Doritos',
                        'Margarita'  => 'Margarita',
                        'Cheetos'    => 'Cheetos',
                        'Choclitos'  => 'Choclitos',
                        'Manimoto'   => 'Manimoto',
                        'Galletas'   => 'Galletas',
                        'Loncheras'  => 'Loncheras',
                    ])
                    ->required(),

                TextInput::make('minQuantity')
                    ->label('Cantidad Mínima')
                    ->numeric()
                    ->nullable()
                    ->default(0),

                Toggle::make('available')
                    ->label('Disponible')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('image')
                    ->label('Imagen')
                    ->getStateUsing(fn ($record) => 
                        $record->image 
                            ? Storage::disk('public')->url($record->image) 
                            : null
                    )
                    ->rounded(),

                TextColumn::make('price')
                    ->label('Precio')
                    ->money('COP'),

                TextColumn::make('category')
                    ->label('Categoría')
                    ->sortable(),

                TextColumn::make('minQuantity')
                    ->label('Cant. Mínima')
                    ->sortable(),

                BooleanColumn::make('available')
                    ->label('Disponible'),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
