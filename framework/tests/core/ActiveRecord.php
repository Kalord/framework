<?php
require '../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use app\framework\tests\models\Post;

/**
 * Тестирование ActiveRecord
 *
 * TODO: Сделать процесс создания фикстур базы данных
 * @see https://trello.com/c/TtBkwySl/5-%D1%81%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C-%D0%BF%D1%80%D0%BE%D1%86%D0%B5%D1%81%D1%81-%D1%81%D0%BE%D0%B7%D0%B4%D0%B0%D0%BD%D0%B8%D1%8F-%D1%84%D0%B8%D0%BA%D1%81%D1%82%D1%83%D1%80-%D0%B1%D0%B0%D0%B7%D1%8B-%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85
 *
 * Структура базы данных:
 * sql```
 * CREATE DATABASE framework_test
 * ```
 *
 * sql```
 * CREATE TABLE post (
 *      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
 *      title VARCHAR(30) NOT NULL,
 *      content TEXT NOT NULL
 * )
 * ```
 *
 * sql```
 * INSERT INTO post (title, content) VALUES ('Hello', 'Foo');
 * INSERT INTO post (title, content) VALUES ('Test', 'Bar');
 * INSERT INTO post (title, content) VALUES ('Test', 'Test');
 * ```
 *
 * Таблица post:
 *      ++++++++++++++++++++++++
 *      + id + title + content +
 *      ++++++++++++++++++++++++
 *      + 1  + Hello + Foo     +
 *      ++++++++++++++++++++++++
 *      + 2  + Test  + Bar     +
 *      ++++++++++++++++++++++++
 *      + 3  + Test  + Test    +
 *      ++++++++++++++++++++++++
 *
 * @author Artem Tyutnev <artem.tyutnev.developer@gmail.com>
 */
class ActiveRecord extends TestCase
{
    /**
     * @var object
     */
    private $model;

    /**
     * @var string
     */
    private $pathToConfig;

    protected function setUp(): void
    {
        $this->model = new Post();
        $this->pathToConfig = '../configs/db-test.php';
    }

    public function testSelectAll()
    {
        $posts = Post::query($this->pathToConfig)->select()->all();
        $this->assertIsArray($posts);

        foreach($posts as $post)
        {
            $this->assertObjectHasAttribute('id', $post);
            $this->assertObjectHasAttribute('title', $post);
            $this->assertObjectHasAttribute('content', $post);
        }

        $posts = Post::query($this->pathToConfig)->select(['id'])->all();

        foreach($posts as $post)
        {
            $this->assertObjectHasAttribute('id', $post);
            $this->assertObjectNotHasAttribute('title', $post);
            $this->assertObjectNotHasAttribute('content', $post);
        }

    }

    public function testSelectOne()
    {
        $post = Post::query($this->pathToConfig)->select()->one();
        $this->assertIsObject($post);

        $this->assertObjectHasAttribute('id', $post);
        $this->assertObjectHasAttribute('title', $post);
        $this->assertObjectHasAttribute('content', $post);
    }

    public function testWhereAll()
    {
        $posts = Post::query($this->pathToConfig)->select()->where(['!=', 'id_user', 1])->all();
        $this->assertTrue(empty($posts));

        $posts = Post::query($this->pathToConfig)->select()->where(['>', 'id', 100])->all();
        $this->assertNull($posts);

        $posts = Post::query($this->pathToConfig)->select()->where(['<', 'id', 2])->all();
        $this->assertEquals(1, count($posts));
    }

    public function testWhereOne()
    {
        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $this->assertEquals(1, $post->id);

        $post = Post::query($this->pathToConfig)->select()->where(['id' => 100])->one();
        $this->assertNull($post);
    }

    public function testAndWhere()
    {
        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->andWhere(['id_user' => 1])->one();
        $this->assertIsObject($post);
    }

    public function testOrWhere()
    {
        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->orWhere(['id' => 2])->one();
        $this->assertIsObject($post);
    }

    public function testInnerJoin()
    {
        $posts = Post::query($this->pathToConfig)->select()->
                                                  innerJoin('user')->
                                                  on(['post.id_user' => 'user.id'])->
                                                  all();
        $post = array_shift($posts);

        $this->assertIsObject($post);
        $this->assertObjectHasAttribute('title', $post);
        $this->assertObjectHasAttribute('login', $post);
    }

    public function testLeftJoin()
    {
        $posts = Post::query($this->pathToConfig)->select()->leftJoin('user')->on(['post.id_user' => 'user.id'])->all();
        $post = array_shift($posts);
        $this->assertIsObject($post);
        $this->assertObjectHasAttribute('title', $post);
        $this->assertObjectHasAttribute('login', $post);
    }

    public function testRightJoin()
    {
        $posts = Post::query($this->pathToConfig)->select()->rightJoin('user')->on(['post.id_user' => 'user.id'])->all();
        $post = array_shift($posts);
        $this->assertIsObject($post);
        $this->assertObjectHasAttribute('title', $post);
        $this->assertObjectHasAttribute('login', $post);
    }

    public function testInsert()
    {
        $result = Post::query($this->pathToConfig)->insert([
            'title' => 'TEST',
            'content' => 'TEST',
            'id_user' => 1
        ])->execute();
        $this->assertTrue($result);

        $post = Post::query($this->pathToConfig)->select()->where(['title' => 'TEST'])->one();
        $this->assertIsObject($post);
        $this->assertObjectHasAttribute('title', $post);
    }

    public function testUpdate()
    {
        $result = Post::query($this->pathToConfig)->update(['title' => 'TEST'])->where(['id' => 1])->execute();
        $this->assertTrue($result);

        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $this->assertIsObject($post);
        $this->assertEquals('TEST', $post->title);

        $result = Post::query($this->pathToConfig)->update(['title' => 'Hello'])->execute();
        $this->assertTrue($result);

        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $this->assertIsObject($post);
        $this->assertEquals('Hello', $post->title);
    }

    public function testDelete()
    {
        $result = Post::query($this->pathToConfig)->delete()->where(['>', 'id', 3])->execute();
        $this->assertTrue($result);

        $posts = Post::query($this->pathToConfig)->select()->all();
        $this->assertEquals(3, count($posts));
    }

    public function testIsArrayAll()
    {
        $posts = Post::query($this->pathToConfig)->select()->asArray()->all();
        foreach($posts as $post)
        {
            $this->assertIsArray($post);
        }
    }

    public function testIsArrayOne()
    {
        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->asArray()->one();
        $this->assertIsArray($post);
    }

    public function testLimit()
    {
        $posts = Post::query($this->pathToConfig)->select()->limit(1)->all();
        $this->assertEquals(1, count($posts));

        $posts = Post::query($this->pathToConfig)->select()->limit(3)->all();
        $this->assertEquals(3, count($posts));
    }

    public function testOrderBy()
    {
        $posts = Post::query($this->pathToConfig)->select()->orderBy(['id' => SORT_ASC])->all();
        $maxId = $posts[count($posts) - 1]->id;
        foreach($posts as $post) $this->assertTrue($maxId >= $post->id);

        $posts = Post::query($this->pathToConfig)->select()->orderBy(['id' => SORT_DESC])->all();
        $maxId = $posts[0]->id;
        foreach($posts as $post) $this->assertTrue($maxId >= $post->id);
    }

    public function testSave()
    {
        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $post->title = 'New';
        $this->assertTrue($post->save());

        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $this->assertEquals('New', $post->title);

        $post = Post::query($this->pathToConfig)->select()->where(['id' => 1])->one();
        $post->title = 'Hello';
        $this->assertTrue($post->save());
    }
}