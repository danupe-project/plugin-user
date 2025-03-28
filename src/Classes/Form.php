<?php

namespace Danupe\Plugin\User\Classes;

class Form
{
    public static function input(string $name, string $type = 'text', string|null $value = '', array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' border rounded px-4 py-2 w-full';
        $attr = self::buildAttributes($attributes);
        return "<input type=\"$type\" name=\"$name\" value=\"$value\" $attr>";
    }

    public static function password(string $name, string $type = "password", string|null $value = "", array $attributes = [])
    {
        $attributes["class"] = ($attributes["class"] ?? "") . " border rounded px-4 py-2 w-full";
        $attr = self::buildAttributes($attributes);
        return "<input type=\"password\" name=\"$name\" value=\"$value\" $attr>";
    }

    public static function textarea(string $name, string|null $value = '', array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' border rounded px-4 py-2 w-full';
        $attr = self::buildAttributes($attributes);
        return "<textarea name=\"$name\" $attr>$value</textarea>";
    }

    public static function select(string $name, array $options = [], null|int $selected = null, array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' border rounded px-4 py-2 w-full';
        $attr = self::buildAttributes($attributes);
        $optionsHtml = '';
        foreach ($options as $value => $label) {
            $isSelected = $value == $selected ? 'selected' : '';
            $optionsHtml .= "<option value=\"$value\" $isSelected>$label</option>";
        }
        return "<select name=\"$name\" $attr>$optionsHtml</select>";
    }

    public static function checkbox(string $name, string $value = '1', bool $checked = false, array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' rounded border-gray-300 text-indigo-600 focus:ring-indigo-500';
        $attr = self::buildAttributes($attributes);
        $isChecked = $checked ? 'checked' : '';
        return "<input type=\"checkbox\" name=\"$name\" value=\"$value\" $isChecked $attr>";
    }

    public static function submit(string $value = 'Submit', array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700';
        $attr = self::buildAttributes($attributes);
        return "<button type=\"submit\" $attr>$value</button>";
    }

    public static function file(string $name, array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' border rounded px-4 py-2 w-full';
        $attr = self::buildAttributes($attributes);
        return "<input type=\"file\" name=\"$name\" $attr>";
    }

    public static function wysiwyg(string $name, string $value = '', array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' border rounded px-4 py-2 w-full';
        $attr = self::buildAttributes($attributes);
        return "
            <div x-data=\"{ content: '$value' }\" class=\"wysiwyg-editor\">
                <textarea x-model=\"content\" name=\"$name\" $attr></textarea>
                <div class=\"mt-2 border rounded p-2\" x-html=\"content\"></div>
            </div>
        ";
    }

    private static function buildAttributes(array $attributes)
    {
        $html = '';
        foreach ($attributes as $key => $value) {
            $html .= "$key=\"$value\" ";
        }
        return trim($html);
    }

    public static function label(string $for, string $text, array $attributes = [])
    {
        $attributes['class'] = ($attributes['class'] ?? '') . ' font-bold text-gray-700';
        $attr = self::buildAttributes($attributes);
        return "<label for=\"$for\" $attr>$text</label>";
    }

    public static function csrf(string $token="")
    {
        if(empty($token)){
            $token = $_SESSION['csrf_token'] ?? '';
        }
        return "<input type=\"hidden\" name=\"csrf_token\" value=\"$token\">";
    }
}


