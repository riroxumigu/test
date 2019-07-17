<?php namespace App\Tests;
use App\Entity\Post;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class PostCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testPostsList(ApiTester $I)
    {
        $post = new Post();
        $post->setName('aa')
            ->setValue('155');
        $I->sendGET("/");
        $I->haveInRepository(Post::class, ['name' => 'aa']);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->amOnPage('/');
        $I->seeNumberOfElements('p', 1);
        $I->seeNumberOfElements('ul', 1);
        $I->seeNumberOfElements('li', 1);
    }

    public function testPostRequest(ApiTester $I)
    {
        $I->sendPOST('/');
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
