<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('name'))
                    ->required()
                    ->maxLength(255),
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
                    ->label(__('gender'))
                    ->options([
                        'male' => __('male'),
                        'female' =>__( 'female'),
                    ]),
//                    ->maxLength(255),
                Forms\Components\TextInput::make('collage')
                    ->label(__('collage'))
                    ->maxLength(255),
//                Forms\Components\TextInput::make('level_id')
//                    ->numeric(),
                Forms\Components\TextInput::make('job')
                    ->label(__('job')),
                Forms\Components\Select::make('father_id')
                    ->label(__('the father'))
                    ->relationship('father', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('gender')
                    ->label(__('gender'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('collage')
                    ->label(__('collage'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('job')
                    ->label(__('job')),
                Tables\Columns\TextColumn::make('father.name')
                    ->label(__('the father')),
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
        return __('teachers');
    }
    public static function getModelLabel(): string
    {
        return __('teacher');
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
