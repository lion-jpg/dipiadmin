<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducacionResource\Pages;
use App\Filament\Resources\EducacionResource\RelationManagers;
use App\Models\Educacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EducacionResource extends Resource
{
    protected static ?string $model = Educacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Educación';
    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationBadgeTooltip = 'The number of educacion ';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo_edu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion_edu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imagen_edu')
                    ->preserveFilenames(),
                Forms\Components\FileUpload::make('video_edu')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo_edu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion_edu')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen_edu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_edu')
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
            'index' => Pages\ListEducacions::route('/'),
            'create' => Pages\CreateEducacion::route('/create'),
            'edit' => Pages\EditEducacion::route('/{record}/edit'),
        ];
    }
}
