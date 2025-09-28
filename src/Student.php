<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

namespace STH\SecurityExercises;

final class Student
{
    public function __construct(
        public readonly string $id,
        public string $name,
        private float $gpa = 0.0
    ) {
        $this->assertGpaRange($this->gpa);
    }

    /** @var string[] */
    private array $courses = [];

    public function enroll(string $code): void
    {
        // ตัวอย่าง validation ง่าย ๆ
        if (!preg_match('/^[A-Z]{3,4}\d{3}$/', $code)) {
            throw new \InvalidArgumentException("Invalid course code: $code");
        }
        $this->courses[] = $code;
    }

    public function setGpa(float $gpa): void
    {
        $this->assertGpaRange($gpa);
        $this->gpa = $gpa;
    }

    public function getGpa(): float
    {
        return $this->gpa;
    }

    /** @return string[] */
    public function courses(): array
    {
        return $this->courses;
    }

    private function assertGpaRange(float $gpa): void
    {
        if ($gpa < 0.0 || $gpa > 4.0) {
            throw new \InvalidArgumentException("GPA must be 0.0–4.0");
        }
    }

    public function __toString(): string
    {
        $c = implode(', ', $this->courses);
        return "Student {$this->id} {$this->name}, GPA={$this->gpa}, Courses=[$c]";
    }
}