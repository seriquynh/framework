<?php

namespace Illuminate\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\Gate;

class Can implements ValidatorAwareRule, ValidationRule
{
    /**
     * The ability to check.
     *
     * @var string
     */
    protected $ability;

    /**
     * The arguments to pass to the authorization check.
     *
     * @var array
     */
    protected $arguments;

    /**
     * The current validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Constructor.
     *
     * @param  string  $ability
     * @param  array  $arguments
     */
    public function __construct($ability, array $arguments = [])
    {
        $this->ability = $ability;
        $this->arguments = $arguments;
    }

    /**
     * Set the current validator.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $arguments = $this->arguments;

        $model = array_shift($arguments);

        $passes = Gate::allows($this->ability, array_filter([$model, ...$arguments, $value]));

        if (! $passes) {
            $message = $this->validator->getTranslator()->get('validation.can');

            $fail($message === 'validation.can' ? 'The :attribute field contains an unauthorized value.' : $message);
        }
    }
}
