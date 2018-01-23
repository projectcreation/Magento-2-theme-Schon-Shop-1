<?php

namespace Schon\NavMenuHeader\Block;

use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;


class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{

	/**
	 * Add sub menu HTML code for current menu item
	 *
	 * @param \Magento\Framework\Data\Tree\Node $child
	 * @param string $childLevel
	 * @param string $childrenWrapClass
	 * @param int $limit
	 * @return string HTML code
	 */
	protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
	{
		$html = '';
		if (!$child->hasChildren()) {
			return $html;
		}

		$colStops = null;
		if ($childLevel == 0 && $limit) {
			$colStops = $this->_columnBrake($child->getChildren(), $limit);
		}

		$html .= '<a href="#" class="pull-left  dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
		$html .= '<svg class="main-navbar__vertical-allign" width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">';
		$html .= '<path d="M1395 736q0 13-10 23l-466 466q-10 10-23 10t-23-10l-466-466q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l393 393 393-393q10-10 23-10t23 10l50 50q10 10 10 23z"></path>';
		$html .= '</svg>';
		$html .= '</a>';

		$html .= '<ul class="level' . $childLevel . ' ' . $childrenWrapClass . '">';
		$html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
		$html .= '</ul>';

		return $html;
	}




	/**
	 * Recursively generates top menu html from data that is specified in $menuTree
	 *
	 * @param \Magento\Framework\Data\Tree\Node $menuTree
	 * @param string $childrenWrapClass
	 * @param int $limit
	 * @param array $colBrakes
	 * @return string
	 *
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 */
	protected function _getHtml(
		\Magento\Framework\Data\Tree\Node $menuTree,
		$childrenWrapClass,
		$limit,
		$colBrakes = []
	) {
		$html = '';

		$children = $menuTree->getChildren();
		$parentLevel = $menuTree->getLevel();
		$childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

		$counter = 1;
		$itemPosition = 1;
		$childrenCount = $children->count();

		$parentPositionClass = $menuTree->getPositionClass();
		$itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

		/** @var \Magento\Framework\Data\Tree\Node $child */
		foreach ($children as $child) {
			if ($childLevel === 0 && $child->getData('is_parent_active') === false) {
				continue;
			}
			$child->setLevel($childLevel);
			$child->setIsFirst($counter == 1);
			$child->setIsLast($counter == $childrenCount);
			$child->setPositionClass($itemPositionClassPrefix . $counter);

			$outermostClassCode = '';
			$outermostClass = $menuTree->getOutermostClass();

			if ($childLevel == 0 && $outermostClass) {
				$outermostClassCode = ' class="' . $outermostClass . ' pull-left" ';                                    // add pull-left ( from bootstrap )
				$child->setClass($outermostClass);
			}

			if (count($colBrakes) && $colBrakes[$counter]['colbrake']) {
				$html .= '</ul></li><li class="column"><ul>';
			}

			$html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
			$html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml(
					$child->getName()
				) . '</span></a>' . $this->_addSubMenu(
					$child,
					$childLevel,
					$childrenWrapClass,
					$limit
				) . '</li>';
			$itemPosition++;
			$counter++;
		}

		if (count($colBrakes) && $limit) {
			$html = '<li class="column"><ul>' . $html . '</ul></li>';
		}

		return $html;
	}

}
