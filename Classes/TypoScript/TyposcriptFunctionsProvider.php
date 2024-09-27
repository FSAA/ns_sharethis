<?php
namespace Nitsan\NsSharethis\TypoScript;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class TyposcriptFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            $this->checkGlobal()
        ];
    }

    protected function checkGlobal(): ExpressionFunction
    {
        return new ExpressionFunction('ShareThisCheckGlobal', function () {
            // Not implemented
        }, function () {
            $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ns_sharethis']) ? unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ns_sharethis']) : '';

            if (isset($configuration['globalSharing']) and $configuration['globalSharing'] == 1) {
                return true;
            } else {
                return false;
            }
        });
    }
}
