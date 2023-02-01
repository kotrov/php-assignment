<?php

declare(strict_types=1);

namespace Tests\feature;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ATestTest
 *
 * @package Tests\feature
 */
class EndpointTest extends TestCase
{

    /**
     * @test
     */
    public function testStatisticsEndpoint(): void
    {
        $client = new Client([
            'base_uri' => 'http://sm_assignment_app_web/',
        ]);

        $response = $client->get('/statistics', [
            'query' => ['start_date' => 'September, 2022', 'end_date' => 'February, 2023']
        ]);
        $responseData = $response->getBody()->getContents();
        $responseDataArray = json_decode($responseData, true);

        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertJson($responseData);

        $this->assertIsArray($responseDataArray);
        $this->assertTrue(count($responseDataArray) === 4);
        $this->assertArrayHasKey('stats', $responseDataArray);
        $this->assertTrue(isset($responseDataArray['stats']['children']));

    }
}
