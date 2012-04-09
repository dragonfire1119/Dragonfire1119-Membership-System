<?php
class View_Standard extends View {
	public function render() {
		echo '<form', $this->form->getAttributes(), '>';
		$this->form->getError()->render();

		$elements = $this->form->getElements();
		$elementSize = sizeof($elements);
		$elementCount = 0;
		for($e = 0; $e < $elementSize; ++$e) {
			$element = $elements[$e];

			if($element instanceof Element_Hidden || $element instanceof Element_HTMLExternal)
                $element->render();
            elseif($element instanceof Element_Button) {
                if($e == 0 || !$elements[($e - 1)] instanceof Element_Button)
                    echo '<div class="pfbc-element pfbc-buttons">';
                $element->render();
                if(($e + 1) == $elementSize || !$elements[($e + 1)] instanceof Element_Button)
                    echo '</div>';
            }
            else {
				echo '<div id="pfbc-element-', $elementCount, '" class="pfbc-element">', $element->getPreHTML();
				$this->renderLabel($element);
				$element->render();
				echo $element->getPostHTML(), '</div>';
				++$elementCount;
			}
		}

		echo '</form>';
    }

	public function renderCSS() {
		$id = $this->form->getId();
		$width = $this->form->getWidth();
		$widthSuffix = $this->form->getWidthSuffix();

		parent::renderCSS();
		echo <<<CSS
#$id { width: $width{$widthSuffix}; }
#$id .pfbc-element { margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #f4f4f4; }
#$id .pfbc-label { margin-bottom: .25em; }
#$id .pfbc-label label { display: block; }
#$id .pfbc-textbox, #$id .pfbc-textarea, #$id .pfbc-select { width: $width{$widthSuffix}; }
#$id .pfbc-buttons { text-align: right; }
CSS;
		
		$elements = $this->form->getElements();
		$elementSize = sizeof($elements);
		$elementCount = 0;
		for($e = 0; $e < $elementSize; ++$e) {
			$element = $elements[$e];
			$elementWidth = $element->getWidth();
			if(!$element instanceof Element_Hidden && !$element instanceof Element_HTMLExternal && !$element instanceof Element_HTMLExternal) {
				if(!empty($elementWidth)) {
					echo '#', $id, ' #pfbc-element-', $elementCount, ' { width: ', $elementWidth, $widthSuffix, '; }';
					echo '#', $id, ' #pfbc-element-', $elementCount, ' .pfbc-textbox, #', $id, ' #pfbc-element-', $elementCount, ' .pfbc-textarea, #', $id, ' #pfbc-element-', $elementCount, ' .pfbc-select { width: ', $elementWidth, $widthSuffix, '; }';
				}	
				$elementCount++;
			}
		}
	}
}
