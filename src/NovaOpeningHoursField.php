<?php

namespace SadekD\NovaOpeningHoursField;

use Illuminate\Validation\ValidationException;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\OpeningHours\Exceptions\Exception as OpeningHoursException;
use Spatie\OpeningHours\OpeningHours;

class NovaOpeningHoursField extends Field
{
    use SupportsDependentFields;

    public $component = 'nova-opening-hours-field';

    private $allowOverflowMidnight;

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->allowExceptions(TRUE);
        $this->allowOverflowMidnight(FALSE);
        $this->useTextInputs(FALSE);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $value = json_decode($request[$requestAttribute], TRUE);

            $data = array_merge([
                'overflow' => (bool)$this->allowOverflowMidnight,
            ], $value);

            try {
                if (isset($data['exceptions'])) {
                    $cleanData = [];
                    foreach ($data['exceptions'] as $key => $entry) {
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                            $cleanData[$key] = $entry;
                        } elseif (preg_match('/^\d{2}-\d{2}$/', $key)) {
                            $cleanData[$key] = $entry;
                        }
                    }
                    $data['exceptions'] = $cleanData;
                }

                OpeningHours::create($data);
                unset($data['overflow']);
            } catch (OpeningHoursException $exception) {
                $message = str_replace('Y-m-d, e.g. `2016-12-25`.', 'm-d, e.g. `12-25`.', $exception->getMessage());
                throw ValidationException::withMessages([$requestAttribute => $message]);
            }

            $model->{$attribute} = $this->isNullValue($request[$requestAttribute]) ? NULL : $data;
        }
    }

    public function allowExceptions(bool $value)
    {
        return $this->withMeta(['allowExceptions' => $value]);
    }

    public function allowOverflowMidnight(bool $value)
    {
        $this->allowOverflowMidnight = $value;
        return $this->withMeta(['allowOverflowMidnight' => $value]);
    }

    public function useTextInputs(bool $value)
    {
        return $this->withMeta(['useTextInputs' => $value]);
    }
}
