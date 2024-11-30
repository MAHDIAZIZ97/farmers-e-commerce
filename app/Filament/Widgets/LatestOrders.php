<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class  LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at','desc')
            ->columns([
            TextColumn::make('id')
                ->label('Order ID')
                ->searchable(true),
            TextColumn::make('user.name')
                ->searchable()
                ->sortable(),
             TextColumn::make('grand_total')
                ->money('INR'),
             TextColumn::make('status')
                ->badge()
                ->color(fn (string $state) => match($state){
                    'new' => 'info',
                    'processing' => 'warning',
                    'shipped' => 'success',
                    'delivered' => 'primary',
                    'cancelled' => 'danger',
                })
                ->icon(
                 fn (string $state) => match($state){
                     'new' => 'heroicon-m-sparkles',
                     'processing' => 'heroicon-m-arrow-path',
                     'shipped' => 'heroicon-m-track',
                     'delivered' => 'heroicon-m-check-badge',
                     'cancelled' => 'heroicon-m-x-circle',
                 }
                )
                ->sortable(),
             TextColumn::make('payment_method')
                 ->sortable()
                 ->searchable(true),
             TextColumn::make('payment_status')
                 ->sortable(true)
                 ->badge()
                 ->searchable(true),
             TextColumn::make('created_at')
                ->label('Order Date')
                ->datetime(),
             // Add more columns as needed...
            ])
         ->actions(
            [
                Action::make('View Order')
                   ->url(fn (Order $record) =>OrderResource::getUrl('view',['record'=>$record]))
                   ->icon('heroicon-m-eye')
            ]
            );
    }
}
