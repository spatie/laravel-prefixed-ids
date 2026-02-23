<?php

use Spatie\PrefixedIds\Exceptions\NoPrefixConfiguredForModel;
use Spatie\PrefixedIds\Exceptions\NoPrefixedModelFound;
use Spatie\PrefixedIds\PrefixedIds;
use Spatie\PrefixedIds\Tests\TestClasses\Models\OtherTestModel;
use Spatie\PrefixedIds\Tests\TestClasses\Models\TestModel;

beforeEach(function () {
    PrefixedIds::registerModels([
        'test_' => TestModel::class,
        'other_test_' => OtherTestModel::class,
    ]);
});

it('generates prefixed id using method', function () {
    PrefixedIds::generateUniqueIdUsing(function () {
        return 'foo';
    });

    $testModel = TestModel::create();

    expect($testModel->prefixed_id)->toBe('test_foo');
});

it('will generate unique ids using method', function () {
    PrefixedIds::generateUniqueIdUsing(function () {
        return rand();
    });

    $testModel = TestModel::create();
    $secondTestModel = TestModel::create();

    expect($testModel->prefixed_id)->toStartWith('test_')
        ->and($secondTestModel->prefixed_id)->toStartWith('test_')
        ->and($testModel->prefixed_id)->not->toBe($secondTestModel->prefixed_id);
});

it('can generate a prefixed id', function () {
    $testModel = TestModel::create();

    expect($testModel->prefixed_id)->toStartWith('test_');
});

it('will generate unique ids', function () {
    $testModel = TestModel::create();
    $secondTestModel = TestModel::create();

    expect($testModel->prefixed_id)->toStartWith('test_')
        ->and($secondTestModel->prefixed_id)->toStartWith('test_')
        ->and($testModel->prefixed_id)->not->toBe($secondTestModel->prefixed_id);
});

it('can find a record with the given prefixed id', function () {
    $testModel = TestModel::create();

    $foundModel = TestModel::findByPrefixedId($testModel->prefixed_id);

    expect($foundModel->id)->toBe($testModel->id);

    $foundModel = TestModel::findByPrefixedId('non_existing');
    expect($foundModel)->toBeNull();
});

it('will throw an exception if the model is not configured', function () {
    PrefixedIds::clearRegisteredModels();

    TestModel::create();
})->throws(NoPrefixConfiguredForModel::class);

it('can find the right model for the given prefixed id', function () {
    $testModel = TestModel::create();
    $otherTestModel = OtherTestModel::create();

    $foundModel = PrefixedIds::find($testModel->prefixed_id);
    expect($foundModel)->toBeInstanceOf(TestModel::class)
        ->and($foundModel->id)->toBe($testModel->id);

    $otherFoundModel = PrefixedIds::find($otherTestModel->prefixed_id);
    expect($otherFoundModel)->toBeInstanceOf(OtherTestModel::class)
        ->and($otherFoundModel->id)->toBe($testModel->id);

    $nonExistingModel = PrefixedIds::find('non-existing-id');
    expect($nonExistingModel)->toBeNull();
});

it('can find or fail a record with the given prefixed id', function () {
    $testModel = TestModel::create();

    $foundModel = TestModel::findByPrefixedIdOrFail($testModel->prefixed_id);
    expect($foundModel->id)->toBe($testModel->id);
});

it('throws exception on invalid prefixed id', function () {
    TestModel::findByPrefixedIdOrFail('non_existing');
})->throws(NoPrefixedModelFound::class);

it('can find or fail the right model for the given prefixed id', function () {
    $testModel = TestModel::create();
    $otherTestModel = OtherTestModel::create();

    $foundModel = PrefixedIds::findOrFail($testModel->prefixed_id);
    expect($foundModel)->toBeInstanceOf(TestModel::class)
        ->and($foundModel->id)->toBe($testModel->id);

    $otherFoundModel = PrefixedIds::findOrFail($otherTestModel->prefixed_id);
    expect($otherFoundModel)->toBeInstanceOf(OtherTestModel::class)
        ->and($otherFoundModel->id)->toBe($testModel->id);
});

it('throws exception on invalid given model prefixed id', function () {
    PrefixedIds::findOrFail('non-existing-id');
})->throws(NoPrefixedModelFound::class);
