<?php
/**
 * Created by PhpStorm.
 * User: lneicelis
 * Date: 2017.06.07
 * Time: 13:33
 */

namespace Lneicelis\QueueBundle;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;

class CustomExceptionHandler implements ExceptionHandler {

    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement report() method.
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement render() method.
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        var_dump($e->getMessage());
        // TODO: Implement renderForConsole() method.
    }
}