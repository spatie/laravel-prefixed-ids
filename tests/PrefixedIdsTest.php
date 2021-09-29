<?php

namespace Spatie\PrefixedIds\Tests;

use Spatie\PrefixedIds\Exceptions\NoPrefixConfiguredForModel;
use Spatie\PrefixedIds\Exceptions\NoPrefixedModelFound;
use Spatie\PrefixedIds\PrefixedIds;
use Spatie\PrefixedIds\Tests\TestClasses\Models\OtherTestModel;
use Spatie\PrefixedIds\Tests\TestClasses\Models\TestModel;

class PrefixedIdsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        PrefixedIds::registerModels([
            'test_' => TestModel::class,
            'other_test_' => OtherTestModel::class,
        ]);
    }

    /** @test */
    public function it_can_generated_a_prefixed_it()
    {
        $testModel = TestModel::create();

        $this->assertStringStartsWith('test_', $testModel->prefixed_id);
    }

    /** @test */
    public function it_will_generate_unique_ids()
    {
        $testModel = TestModel::create();
        $secondTestModel = TestModel::create();

        $this->assertStringStartsWith('test_', $testModel->prefixed_id);
        $this->assertStringStartsWith('test_', $secondTestModel->prefixed_id);
        $this->assertNotEquals($testModel->prefixed_id, $secondTestModel->prefixed_id);
    }

    /** @test */
    public function a_model_can_find_a_record_with_the_given_prefixed_id()
    {
        $testModel = TestModel::create();

        $foundModel = TestModel::findByPrefixedId($testModel->prefixed_id);

        $this->assertEquals($testModel->id, $foundModel->id);

        $foundModel = TestModel::findByPrefixedId('non_existing');
        $this->assertNull($foundModel);
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_model_is_not_configured()
    {
        PrefixedIds::clearRegisteredModels();

        $this->expectException(NoPrefixConfiguredForModel::class);

        TestModel::create();
    }

    /** @test */
    public function it_can_find_the_right_model_for_the_given_prefixed_id()
    {
        $testModel = TestModel::create();
        $otherTestModel = OtherTestModel::create();

        $foundModel = PrefixedIds::find($testModel->prefixed_id);
        $this->assertInstanceOf(TestModel::class, $foundModel);
        $this->assertEquals($testModel->id, $foundModel->id);

        $otherFoundModel = PrefixedIds::find($otherTestModel->prefixed_id);
        $this->assertInstanceOf(OtherTestModel::class, $otherFoundModel);
        $this->assertEquals($testModel->id, $otherFoundModel->id);

        $nonExistingModel = PrefixedIds::find('non-existing-id');
        $this->assertNull($nonExistingModel);
    }

    /** @test */
    public function a_model_can_find_a_record_with_the_given_prefixed_id_or_fail()
    {
        $testModel = TestModel::create();

        $foundModel = TestModel::findByPrefixedIdOrFail($testModel->prefixed_id);
        $this->assertEquals($testModel->id, $foundModel->id);

        $foundModel = TestModel::findByPrefixedIdOrFail('non_existing');
        $this->expectException(NoPrefixedModelFound::class);
    }

    // /** @test */
    public function it_can_find_the_right_model_for_the_given_prefixed_id_or_fail()
    {
        $testModel = TestModel::create();
        $otherTestModel = OtherTestModel::create();

        $foundModel = PrefixedIds::findOrFail($testModel->prefixed_id);
        $this->assertInstanceOf(TestModel::class, $foundModel);
        $this->assertEquals($testModel->id, $foundModel->id);

        $otherFoundModel = PrefixedIds::findOrFail($otherTestModel->prefixed_id);
        $this->assertInstanceOf(OtherTestModel::class, $otherFoundModel);
        $this->assertEquals($testModel->id, $otherFoundModel->id);

        $nonExistingModel = PrefixedIds::findOrFail('non-existing-id');
        $this->expectException(NoPrefixedModelFound::class);
    }
}
