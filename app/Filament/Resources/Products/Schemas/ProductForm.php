<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                
                Textarea::make('description')
                    ->required()
                    ->columnSpan(2)
                    ->rows(4),
                
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('€')
                    ->minValue(0)
                    ->step(0.01),
                
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                
                TextInput::make('condition')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('piece_count')
                    ->numeric()
                    ->default(null)
                    ->minValue(0),
                
                DatePicker::make('release_date')
                    ->native(false),
                
                FileUpload::make('image')
                    ->image()
                    ->directory('images/products')
                    ->maxSize(2048),
            ]);
    }
}
