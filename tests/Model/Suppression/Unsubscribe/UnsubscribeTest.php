<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Model\Suppression\Unsubscribe;

use Worker\Model\Suppression\Unsubscribe\Unsubscribe;
use Worker\Tests\Model\BaseModelTest;

class UnsubscribeTest extends BaseModelTest
{
    /**
     * @test
     */
    public function itGetsEmptyListOfTagsByDefault()
    {
        $unsubscribe = Unsubscribe::create(['address' => 'dummy@worker.net']);
        $this->assertEquals([], $unsubscribe->getTags());
    }

    /**
     * @test
     */
    public function itGetsTags()
    {
        $tags = ['tag1', 'tag2'];
        $unsubscribe = Unsubscribe::create(['address' => 'dummy@worker.net', 'tags' => $tags]);
        $this->assertEquals($tags, $unsubscribe->getTags());
    }
}
