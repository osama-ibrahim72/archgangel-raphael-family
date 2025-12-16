<?php

namespace App\Filament\Resources;

use App\Filament\Exports\StudentExporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

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
                    ->label(__('dob'))
                    ->displayFormat('d/m/Y'),
                Forms\Components\Select::make('gender')
                    ->label(__('gender'))
                    ->options([
                        'male' =>__( 'male'),
                        'female' => __('female'),
                    ]),
                Forms\Components\TextInput::make('collage')
                    ->label(__('collage'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->label(__('job'))
                    ->maxLength(255),
                Forms\Components\Select::make('church_id')
                    ->label(__('church'))
                    ->relationship('church' , 'name'),
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
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->formatStateUsing(fn ($state) => __($state))
                    ->label(__('gender'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('collage')
                    ->label(__('collage'))
                    ->searchable(),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('job')
                    ->label(__('job')),
                Tables\Columns\TextColumn::make('church.name')
                    ->label(__('church'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('father.name')
                    ->label(__('the father')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(StudentExporter::class),

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
        return __('students');
    }
    public static function getModelLabel(): string
    {
        return __('student');
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
