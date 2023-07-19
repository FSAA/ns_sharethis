<?php
namespace Nitsan\NsSharethis\TypoScript;

use Nitsan\NsSharethis\TypoScript\TyposcriptFunctionsProvider;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

class CustomTypoScriptConditionProvider extends AbstractProvider
{
    public function __construct()
    {
        $this->expressionLanguageProviders = [
            TyposcriptFunctionsProvider::class,
        ];
    }
 }