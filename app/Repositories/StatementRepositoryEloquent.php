<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\StatementRepository;
use CodeFin\Models\Statement;
use CodeFin\Validators\StatementValidator;
use Carbon\Carbon;
use CodeFin\Models\CategoryRevenue;
use CodeFin\Models\BillReceive;
use CodeFin\Models\CategoryExpense;
use CodeFin\Models\BillPay;
/**
 * Class StatementRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{
    public function create(array $attributes)
    {
        $statementable = $attributes['statementable'];
        return $statementable->statements()->create(array_except($attributes, 'statementable'));
    }

    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd)
    {
        $datePrevious = $dateStart->copy()->day(1)->subMonths(2);
        $datePrevious->day($datePrevious->daysInMonth);

        $balancePrevious = $this->getBalanceByMonth($datePrevious);

        $revenuesCollection = $this->getCategoriesValuesCollection(new CategoryRevenue(), (new BillReceive())->getTable(), $dateStart, $dateEnd);

        dd($revenuesCollection);

        $expensesCollection = $this->getCategoriesValuesCollection(new CategoryExpense(), (new BillPay())->getTable(), $dateStart, $dateEnd);

        return $this->formatCashFlow($expensesCollection, $revenuesCollection, $balancePrevious);
    }

    protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePrevious)
    {

    }

    public function getBalanceByMonth(Carbon $date)
    {
        $dateString = $date->copy()->day($date->daysInMonth)->format('Y-m-d');
        $modelClass = $this->model;

        $subQuery = (new $modelClass)
            ->toBase()
            ->selectRaw("bank_account_id, MAX(statements.id) as maxid")
            ->whereRaw("statements.created_at <= '$dateString'")
            ->groupBy("bank_account_id");
        
        $result = (new $modelClass)
            ->selectRaw("SUM(statements.balance) as total")
            ->join(\DB::raw("({$subQuery->toSql()}) as s"), 'statements.id', '=', 's.maxid')
            ->mergeBindings($subQuery)
            ->get();
        //query - somar os saldos unicos das contas
        //query - selecionar os ultimos ids de extrato referente a data
        return $result->first()->total === null ? 0 : $result->first()->total; 
    }

    protected function getCategoriesValuesCollection($model, $billTable, Carbon $dateStart, Carbon $dateEnd)
    {
        $dateStartStr = $dateStart->copy()->day(1)->format('Y-m-d');
        $dateEndStr = $dateEnd->copy()->day($dateEnd->daysInMonth)->format('Y-m-d');

        $firstDateStart = $dateStart->copy()->subMonths(1); //first day of the previous month
        $firstDateStartStr = $firstDateStart->format('Y-m-d');

        $firstDateEnd = $firstDateStart->copy()->day($firstDateStart->daysInMonth);
        $firstDateEndStr = $firstDateEnd->format('Y-m-d'); //last day of the previous month

        $firstCollection = $this->getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $firstDateStartStr, $firstDateEndStr)->get();

        $mainCollection = $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStartStr, $dateEndStr)->get();

        $firstCollection->reverse()->each(function($value) use($mainCollection){
            $mainCollection->prepend($value);
        });

        return $mainCollection;
    }

    protected function getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $dateStart, $dateEnd)
    {
        return $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
            ->where('done', 1);
    }

    protected function getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        return $model
                ->addSelect("$table.id")
                ->addSelect("$table.name")
                ->selectRaw("SUM(value) as total")
                ->selectRaw("DATE_FORMAT(date_due, '%Y-%m') as month_year")
                ->selectSub($this->getQueryWithDepth($model), 'depth')
                ->join("$table as childOrSelf", function($join) use($table, $lft, $rgt){
                    $join->on("$table.$lft", '<=', "childOrSelf.$lft")
                        ->whereRaw("$table.$rgt >= childOrSelf.$rgt");
                })
                ->join($billTable, "$billTable.category_id", '=', "childOrSelf.id")
                ->whereBetween('date_due', [$dateStart, $dateEnd])
                ->groupBy("$table.id", "$table.name", 'month_year')
                ->havingRaw("depth = 0")
                ->orderBy("month_year")
                ->orderBy("$table.name");
    }

    protected function getQueryWithDepth($model)
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        $alias = '_d';

        return $model
            ->newScopedQuery($alias)
            ->toBase()
            ->selectRaw('count(1) - 1')
            ->from("{$table} as {$alias}")
            ->whereRaw("{$table}.{$lft} between {$alias}.{$lft} and {$alias}.{$rgt}");
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
