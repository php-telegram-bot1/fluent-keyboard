<?php

namespace PhpTelegramBot\FluentKeyboard;

abstract class KeyboardMarkup extends FluentEntity
{

    /**
     * Defines the field name that contains the rows and buttons.
     *
     * @var string
     */
    protected static $keyboardFieldName = 'keyboard';

    protected $currentRowIndex = 0;

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // Make sure we have one empty row from the beginning
        $this->data[static::$keyboardFieldName] = [[]];
    }

    /**
     * Adds a new row to the keyboard.
     *
     * @param  array  $buttons
     * @return $this
     */
    public function row(array $buttons = [])
    {
        $keyboard = &$this->data[static::$keyboardFieldName];

        // Last row is not empty
        if (! empty($keyboard[$this->currentRowIndex])) {
            $keyboard[] = [];
            $this->currentRowIndex++;
        }

        // argument is not empty
        if (! empty($buttons)) {
            $keyboard[$this->currentRowIndex] = $buttons;
            $this->currentRowIndex++;
        }

        return $this;
    }

    /**
     * Adds buttons one per row to the keyboard.
     *
     * @param  array  $buttons
     * @return $this
     */
    public function stack(array $buttons)
    {
        // Every button gets its own row
        foreach ($buttons as $button) {
            $this->row([$button]);
        }

        return $this;
    }

    /**
     * Adds a button to the last row.
     *
     * @param  \JsonSerializable  $button
     * @return $this
     */
    public function button(\JsonSerializable $button)
    {
        $keyboard = &$this->data[static::$keyboardFieldName];

        $keyboard[$this->currentRowIndex][] = $button;

        return $this;
    }

}