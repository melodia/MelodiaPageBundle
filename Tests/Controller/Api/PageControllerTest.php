<?php

/*
 * This file is part of the Melodia Page Bundle
 *
 * (c) Alexey Ryzhkov <alioch@yandex.ru>
 */

namespace Melodia\PageBundle\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    /**
     * @return int
     */
    public function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', '/api/pages');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return count($jsonResponse);
    }

    /**
     * @return \stdClass
     */
    public function testPost()
    {
        $client = static::createClient();
        $client->request('POST', '/api/pages', array(
            'url' => 'test/test',
            'title' => 'testTitle',
            'description' => 'testDescription',
            'keywords' => 'test,key,word',
            'isActive' => 1,
            'pageBlocks' => array(
                array(
                    'type' => 'one',
                    'json' => '1',
                ),
                array(
                    'type' => 'two',
                    'json' => '2',
                ),
                array(
                    'type' => 'three',
                    'json' => '3',
                ),
            ),
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testGetAll
     *
     * @param int $count
     * @return int
     */
    public function testCountIncremented($count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/pages');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($count + 1, count($jsonResponse));

        return count($jsonResponse);
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     */
    public function testGetOne($object)
    {
        $client = static::createClient();
        $client->request('GET', '/api/pages/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->url, $jsonResponse->url);
        $this->assertEquals($object->title, $jsonResponse->title);
        $this->assertEquals($object->description, $jsonResponse->description);
        $this->assertEquals($object->keywords, $jsonResponse->keywords);
        for ($i = 0; $i < count($object->pageBlocks); $i++) {
            $this->assertEquals($object->pageBlocks[$i]->type, $jsonResponse->pageBlocks[$i]->type);
            $this->assertEquals($object->pageBlocks[$i]->json, $jsonResponse->pageBlocks[$i]->json);
        }
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     * @return \stdClass
     */
    public function testPut($object)
    {
        $client = static::createClient();
        $client->request('PUT', '/api/pages/' . $object->id, array(
            'url' => 'test/test/upd',
            'title' => 'UPD.testTitle',
            'description' => 'UPD.testDescription',
            'keywords' => 'new,key,word',
            'pageBlocks' => array(
                array(
                    'type' => 'one',
                    'json' => '1',
                ),
                array(
                    'type' => 'UPD.two',
                    'json' => '-2',
                ),
                array(
                    'type' => 'three',
                    'json' => '3',
                ),
            ),
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testPut
     *
     * @param \stdClass
     */
    public function testChanged($object)
    {
        $client = static::createClient();
        $client->request('GET', '/api/pages/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->url, $jsonResponse->url);
        $this->assertEquals($object->title, $jsonResponse->title);
        $this->assertEquals($object->description, $jsonResponse->description);
        $this->assertEquals($object->keywords, $jsonResponse->keywords);
        for ($i = 0; $i < count($object->pageBlocks); $i++) {
            $this->assertEquals($object->pageBlocks[$i]->type, $jsonResponse->pageBlocks[$i]->type);
            $this->assertEquals($object->pageBlocks[$i]->json, $jsonResponse->pageBlocks[$i]->json);
        }
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     */
    public function testDelete($object)
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/pages/' . $object->id);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check that object has been deleted
        $client->request('GET', '/api/pages/' . $object->id);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testCountIncremented
     *
     * @param int $count The number of objects after adding the new one
     */
    public function testCountDecremented($count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/pages');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($count - 1, count($jsonResponse));
    }
}
