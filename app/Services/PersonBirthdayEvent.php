<?php


namespace App\Services;


use Carbon\Carbon;
use LaravelEnso\Calendar\app\Contracts\Calendar;
use LaravelEnso\Calendar\app\Contracts\ProvidesEvent;
use LaravelEnso\Calendar\app\Enums\Frequencies;
use LaravelEnso\People\app\Models\Person;

class PersonBirthdayEvent implements ProvidesEvent
{

    private $person;
    private $year;

    public function __construct(Person $person, $year)
    {
        $this->person = $person;
        $this->year = $year;
    }

    public function getKey()
    {
        return $this->person->getKey();
    }

    public function title(): string
    {
        return __(':name `s birthday',['name' => $this->person->name]);
    }

    public function body(): ?string
    {
        return __('Happy Birthday, :name', ['name' => $this->person->appellative]);
    }

    public function start(): Carbon
    {
        return $this->person->birthday
            ->setYear($this->year)
            ->setTime(11,00,00);
    }

    public function end(): Carbon
    {
        return $this->start()
            ->addHours(2);
    }

    public function location(): ?string
    {
        return null;
    }

    public function getCalendar(): Calendar
    {
        return new DemoCalendar();
    }

    public function frequence(): int
    {
        return Frequencies::Yearly;
    }

    public function recurrenceEnds(): ?Carbon
    {
        return null;
    }

    public function allDay(): bool
    {
        return false;
    }

    public function readonly(): bool
    {
        return true;
    }
}
