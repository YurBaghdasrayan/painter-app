<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\RichEditor;

/**
 * Default Filament admin RichEditor toolbar (H1–H6, paragraph, lists, etc.).
 * paragraph = p; lists = ul/ol + li. No built-in generic span control in Filament.
 */
final class AdminRichEditorDefaults
{
    /**
     * @return array<int, array<int, string>>
     */
    public static function toolbarButtons(): array
    {
        return [
            ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'code'],
            ['paragraph', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
            ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
            ['table', 'attachFiles'],
            ['clearFormatting', 'undo', 'redo'],
        ];
    }

    public static function configure(RichEditor $editor): RichEditor
    {
        return $editor->toolbarButtons(self::toolbarButtons());
    }
}
