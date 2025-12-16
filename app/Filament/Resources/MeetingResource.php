<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Filament\Resources\MeetingResource\RelationManagers;
use App\Filament\Resources\MeetingResource\RelationManagers\AttendancesRelationManager;
use App\Filament\Resources\MeetingResource\RelationManagers\SectionsRelationManager;
use App\Models\Meeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('title'))
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->label(__('date')),
                Forms\Components\TimePicker::make('time')
                    ->label(__('time')),
                Forms\Components\Select::make('teacher_id')
                    ->label(__('teacher'))
                    ->relationship('teacher', 'name'),
                Forms\Components\Toggle::make('inside')
                    ->label(__('inside')),
//                    ->numeric(),
                Forms\Components\TextInput::make('notes')
                    ->label(__('notes'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('date'))
                    ->date()
                    ->sortable(),
//                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->label(__('teacher')),
                Tables\Columns\ToggleColumn::make('inside')
                    ->label(__('inside')),
//                Tables\Columns\TextColumn::make('notes')
//                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('updated_at'))
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

    public static function getPluralLabel(): ?string
    {
        return __('meetings');
    }
    public static function getModelLabel(): string
    {
        return __('meeting');
    }


    public static function getRelations(): array
    {
        return [
            SectionsRelationManager::class,
            AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
