<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NutricionResource\Pages;
use App\Filament\Resources\NutricionResource\RelationManagers;
use App\Models\Nutricion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NutricionResource extends Resource
{
    protected static ?string $model = Nutricion::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Nutricion';
    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationBadgeTooltip = 'The number of nutricion';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo_nut')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion_nut')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imagen_nut')
                    ->preserveFilenames(),
                Forms\Components\FileUpload::make('video_nut')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo_nut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion_nut')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen_nut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_nut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListNutricions::route('/'),
            'create' => Pages\CreateNutricion::route('/create'),
            'edit' => Pages\EditNutricion::route('/{record}/edit'),
        ];
    }
}
