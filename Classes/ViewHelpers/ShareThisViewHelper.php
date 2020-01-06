<?php

namespace Nitsan\NsSharethis\ViewHelpers;

use Nitsan\NsSharethis\Util\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Description of ShareThisViewHelper
 *
 * @author SEVER26
 */
class ShareThisViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper 
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;
    
    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments() {
        $this->registerArgument('socials', 'string', '', false, '');
        $this->registerArgument('url', 'string', '', false, '');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $templateVariableContainer = $renderingContext->getVariableProvider();
        $socials = $arguments['socials'];
        $url = $arguments['url'];

        $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ns_sharethis']) ? unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ns_sharethis']) : '';
        
        if($socials === ""){
            $socials = $configuration['socials'];
        }
        
        $socials = explode(',',$socials);
        foreach($socials as $index => $social){
            if(!in_array($social, Utility::ALLOWED_SOCIALS)){
                unset($socials[$index]);
            }
        }
        
        if(!is_array($socials) OR (is_array($socials) AND count($socials) === 0)){
            //TODO use translate
            $content = "invalid socials";
        }
        else{
            
            $data = array(
                'socials' => $socials,
                'url' => $url,
            );
            
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addHeaderData(Utility::getPublicJsRessourcesHtmlTags());
            
            $partialPath = 'EXT:ns_sharethis/Resources/Private/Partials/ShareButtons.html';
            $variables = $templateVariableContainer->getByPath('settings');
            $customPartialsPath = $variables['ns_sharethis']['customPartial'] ?? NULL;
            if($customPartialsPath !== NULL){
                $partialPath = $customPartialsPath;
            }
            
            $view = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
            $view->setTemplatePathAndFilename($partialPath);
            $view->assignMultiple($data);

            $content = $view->render();
        }
        

        return $content;
    }
}
