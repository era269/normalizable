# normalizable

![PHP Stan Badge](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat">)
[![codecov](https://codecov.io/gh/era269/normalizable/branch/main/graph/badge.svg?token=GV9Z0721OI)](https://codecov.io/gh/era269/normalizable)

The normalization which is under the object control.

1. All private object properties should be ready for normalization. the normalization process is easy to customize by
   adding or changing the sequence of the normalizers in the `NormalizationFacade`
2. To allow the normalization customization Object has to implement the next interfaces:
    1. `NormalizableInterface`
    2. `NormalizationFacadeInterface`

## Description:

### NormalizableInterface

The basic interface. Could be used separately to build fully manual normalization. How:

1. any objet implements `NormalizableInterface`
2. It is called object::normalize in `NormalizableInterface::normalize` for all required to be present in normalized
   view objects

### NormalizableTrait

If it is needed to have all normalization happen automatically then `NormalizableTrait` has to be used
with `NormalizableInterface`. In that case all objects should be supported by the `DefaultNormalizationFacade`

#### DefaultNormalizationFacade

Will normalize all private object properties by the next rules:

1. `AsIsKeyDecorator` the property name will become the array key without any decorations
2. all properties will be processed by predefined normalizers:
    1. `NotObjectNormalizer` will return not objects as is
    2. `ListNormalizableToNormalizableAdapterNormalizer` will process the array of normalizable objects
        1. all keys will be left as is `AsIsKeyDecorator`
        2. all values will be processed in according to the current rules by `DefaultNormalizationFacade`
    3. `NormalizableNormalizer` will call `NormalizableInterface::normalize`
    4. `WithTypeNormalizableNormalizerDecorator` is decorates the `NormalizableNormalizer` to add `@type` field with
       ShortClassName of normalized object
    5. `ScalarableNormalizer` will get the scalar value in object implements `ScalarableInterface`
    6. `StringableNormalizer` will get the scalar value in object implements `StringableInterface`
    7. and the last one is `FailNormalizer` which wil throw an exception if no Normalizer was found

### NormalizationFacadeAwareInterface

Should be implenented by all Normalizable objects to support the normalization customization. The normalization should
be initiated by the custom `NormalizationFacade` implementation and it will be set to all Normalizable objects
recursively 
