<?php

/*
var_dump(xdebug_code_coverage_started());
xdebug_start_code_coverage();
var_dump(xdebug_code_coverage_started());
*/
/*
$a = array(1, 2, 3);
$b =& $a;
$c =& $a[2];
echo "\n";
xdebug_debug_zval('a');
echo "\n";
xdebug_debug_zval("a[2]");
echo "\n";
xdebug_debug_zval_stdout('a');
echo "\n";
*/
/*
class Strings
{
    static function fix_string($a)
    {
        echo
            xdebug_call_class().    // to work, set xdebug mode in php file from debug to develop
            "::".
            xdebug_call_function(). // to work, set xdebug mode in php file from debug to develop
            " is called at ".
            xdebug_call_file().     // to work, set xdebug mode in php file from debug to develop
            ":".
            xdebug_call_line();     // to work, set xdebug mode in php file from debug to develop
    }
}
$ret = Strings::fix_string( 'Derick' );
*/
/*
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE); // to work, set xdebugmode in php file to coverage

function a($a) {
    return;
    echo $a * 2.5;
}

function b($count) {
    if ($count > 25) {
        echo "too much\n";
    }
    for ($i = 0; $i < $count; $i++) {
        a($i + 0.17);
    }
}

b(6);
b(10);

var_dump(xdebug_get_code_coverage());
*/
/*
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

function c($count) {
    for ($i = 0; $i < $count; $i++) {
        $i += 0.17;
    }
}

c(10);

var_dump(xdebug_get_code_coverage());
*/
/*
class strings {
    function fix_string($a)
    {
        var_dump(xdebug_get_function_stack());  //set xdebug mode to develop
    }

    function fix_strings($b) {
        foreach ($b as $item) {
            $this->fix_string($item);
        }
    }
}

$s = new strings();
$ret = $s->fix_strings(array('Derick'));
*/
/*
class Handlers
{
    function __construct(private string $title, private float $PIE) {}

    static function exceptionHandler($exception)
    {
        var_dump( xdebug_get_function_stack( [ 'from_exception' => $exception ] ) );
    }
}

class Elephpant
{
    function __construct(private string $title, private string $PIE) {}
}

class Error_Class
{
    public static function newError($errno = false)
    {
        $elephpant = new Elephpant("Bluey", M_PI);
        $randoVar = 42;

        throw new Exception();
    }

}

class Error_Entry
{
    public function __construct($base, $errno)
    {
        $return = Error_Class::newError(true);
    }
}

set_exception_handler(['Handlers', 'exceptionHandler']);
$e = new Error_Entry(1, 2);
*/
/*
header( "X-Test", "Testing" );
setcookie( "TestCookie", "test-value" );
var_dump( xdebug_get_headers() );
 */
/*
// Start the function monitor for strrev and array_push:
xdebug_start_function_monitor( [ 'strrev', 'array_push' ] );

Run some code:
echo strrev("yes!"), "\n";

echo strrev("yes!"), "\n";

var_dump(xdebug_get_monitored_functions());
xdebug_stop_function_monitor();
*/
/*
var_dump( xdebug_info( 'mode' ) ); //dependent on php.ini file, might want to set it to all the three but might be slow

var_dump( xdebug_info( 'extension-flags' ) );
*/
//var_dump(xdebug_is_debugger_active());
/*
function foo( $far, $out )
{
    xdebug_print_function_stack( 'Your own message' );
}
foo( 42, 3141592654 );
*/
echo xdebug_time_index(), "\n";
for ($i = 0; $i < 250000; $i++)
{
    // do nothing
}
echo xdebug_time_index(), "\n";
?>

