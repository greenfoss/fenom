<?php
namespace Aspect;
use Aspect,
    Aspect\Render;

class RenderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Render
     */
    public static $render;

    public static function setUpBeforeClass() {
        self::$render = new Render(Aspect::factory("."), function ($tpl) {
            echo "It is render's function ".$tpl["render"];
        }, array(
            "name" => "render.tpl"
        ));
    }

    public function testCreate() {
        $r = new Render(Aspect::factory("."), function () {
            echo "Test render";
        }, array(
            "name" => "test.render.tpl"
        ));
        $this->assertSame("Test render", $r->fetch(array()));
    }

    public function testDisplay() {
        ob_start();
        self::$render->display(array("render" => "display"));
        $out = ob_get_clean();
        $this->assertSame("It is render's function display", $out);
    }

    public function testFetch() {
        $this->assertSame("It is render's function fetch", self::$render->fetch(array("render" => "fetch")));
    }

    /**
     * @expectedException     \RuntimeException
     * @expectedExceptionMessage template error
     */
    public function testFetchException() {
        $render = new Render(Aspect::factory("."), function () {
            echo "error";
            throw new \RuntimeException("template error");
        }, array(
            "name" => "render.tpl"
        ));
        $render->fetch(array());
    }

}

