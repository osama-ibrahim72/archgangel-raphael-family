<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FatherResource\Pages;
use App\Filament\Resources\FatherResource\RelationManagers;
use App\Models\Father;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FatherResource extends Resource
{
    protected static ?string $model = Father::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->maxLength(255),
//                Forms\Components\DateTimePicker::make('email_verified_at'),
//                Forms\Components\TextInput::make('password')
//                    ->password()
//                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('phone'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(__('address'))
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dob')
                    ->label(__('dob')),
                Forms\Components\Select::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->default('Male')
                    ->hidden(),
                Forms\Components\Select::make('church_id')
                    ->label(__('church'))
                    ->relationship('church' , 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('church.name')
                    ->label(__('church'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->label(__('dob'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('email'))
                    ->searchable(),

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

    public static function getPluralLabel(): ?string
    {
        return __('fathers');
    }
    public static function getModelLabel(): string
    {
        return __('father');
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFathers::route('/'),
            'create' => Pages\CreateFather::route('/create'),
            'edit' => Pages\EditFather::route('/{record}/edit'),
        ];
    }
}
