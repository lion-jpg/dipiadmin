<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProteccionResource\Pages;
use App\Filament\Resources\ProteccionResource\RelationManagers;
use App\Models\Proteccion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProteccionResource extends Resource
{
    protected static ?string $model = Proteccion::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Proteccion';
    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationBadgeTooltip = 'The number of proteccion    ';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo_pro')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion_pro')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imagen_pro')
                    ->preserveFilenames(),
                Forms\Components\FileUpload::make('video_pro')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo_pro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion_pro')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen_pro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_pro')
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
            'index' => Pages\ListProteccions::route('/'),
            'create' => Pages\CreateProteccion::route('/create'),
            'edit' => Pages\EditProteccion::route('/{record}/edit'),
        ];
    }
}
