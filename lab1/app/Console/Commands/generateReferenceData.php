<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\Month;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\Sequence;

class generateReferenceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-reference-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        $initialGroups = Group::factory()
            ->count(8)
            ->state(new Sequence(
                ['GroupName' => 'ИВТ-1'],
                ['GroupName' => 'ИВТ-2'],
                ['GroupName' => 'ИВТ-3'],
                ['GroupName' => 'ИВТ-4'],
                ['GroupName' => 'ИВТ-5'],
                ['GroupName' => 'ИВТ-6'],
                ['GroupName' => 'ИВТ-7'],
                ['GroupName' => 'ИВТ-8']
            ))
            ->create();

        $initialMoths = Month::factory()
            ->count(12)
            ->state(new Sequence(
                ['MonthName' => 'Январь'],
                ['MonthName' => 'Февраль'],
                ['MonthName' => 'Март'],
                ['MonthName' => 'Апрель'],
                ['MonthName' => 'Май'],
                ['MonthName' => 'Июнь'],
                ['MonthName' => 'Июль'],
                ['MonthName' => 'Август'],
                ['MonthName' => 'Сентябрь'],
                ['MonthName' => 'Октябрь'],
                ['MonthName' => 'Ноябрь'],
                ['MonthName' => 'Декабрь']
            ))
            ->create();
        return 0;
    }
}
