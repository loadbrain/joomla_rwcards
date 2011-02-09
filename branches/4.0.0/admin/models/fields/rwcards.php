<?php
// No direct access to this file
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Rwcards Form Field class for the Rwcards component
 */
class JFormFieldRwcards extends JFormFieldList
{
        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'Rwcards';

        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions()
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('id, category_layout_option');
                $query->from('#__rwcardsconfig');
                $db->setQuery((string)$query);
                $category_layout_options = $db->loadObjectList();
                $options = array();
                if ($category_layout_options)
                {
                        foreach($category_layout_option as $category_layout_option)
                        {
                                $options[] = JHtml::_('select.option', $category_layout_option->id, $category_layout_option->category_layout_option);
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }


}

