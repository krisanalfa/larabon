<?php namespace Bonoize\Http\Middleware;

use Bonoize\Http\Requests\CriteriaParser;
use Closure;

class CriteriaAssignor
{
    protected $criteria;

    /**
     * Create a new content negotiator instance.
     *
     * @param  \Bonoize\Http\Requests\CriteriaParser $criteria
     *
     * @return void
     */
    public function __construct(CriteriaParser $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->criteria->parseCriteria($request);
        $this->criteria->parseCommand($request);

        return $next($request);
    }
}
