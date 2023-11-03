<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\GroupByOwnersService;

class GroupByOwnersServiceTest extends TestCase
{
    /**
     * Data provider for testing groupByOwnersService.
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                [
                    "insurance.txt" => "Company A",
                    "letter.docx" => "Company A",
                    "Contract.docx" => "Company B"
                ],
                [
                    "Company A" => ["insurance.txt", "letter.docx"],
                    "Company B" => ["Contract.docx"]
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGroupByOwnersService($input, $expected)
    {
        $groupByOwnersService = new GroupByOwnersService();
        $result = $groupByOwnersService->groupFilesByOwners($input);

        dump($result);

        $this->assertEquals($expected, $result);
    }
}
