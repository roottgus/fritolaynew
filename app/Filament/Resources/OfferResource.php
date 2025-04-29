<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    // Agrupación y orden en el menú
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int    $navigationSort  = 2;

    // Ícono y etiquetas en español
    protected static ?string $navigationIcon   = 'heroicon-o-tag';
    protected static ?string $navigationLabel  = 'Ofertas';
    protected static ?string $pluralLabel      = 'Ofertas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('offers')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('alt')
                    ->label('Texto Alternativo')
                    ->required(),

                Forms\Components\TextInput::make('promotion_message')
                    ->label('Mensaje Promocional')
                    ->placeholder('Promoción del 5%')
                    ->helperText('Este mensaje se mostrará en la imagen al pasar el cursor.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen')
                    ->getStateUsing(fn ($record) =>
                        strpos($record->image, 'offers/') === 0
                            ? asset('storage/' . $record->image)
                            : asset('storage/offers/' . $record->image)
                    ),

                Tables\Columns\TextColumn::make('alt')
                    ->label('Texto Alternativo'),

                Tables\Columns\TextColumn::make('promotion_message')
                    ->label('Mensaje Promocional'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit'   => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
