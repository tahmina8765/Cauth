<?php
/**
 * Tree Helper.
 *
 * Used the generate nested representations of hierarchial data
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2008, Andy Dawson
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright            Copyright (c) 2008, Andy Dawson
 * @link                 www.ad7six.com
 * @package              cake-base
 * @subpackage           cake-base.app.views.helpers
 * @since                v 1.0
 * @version              $Revision: 1358 $
 * @modifiedBy           $LastChangedBy: skie $
 * @lastModified         $Date: 2009-10-15 05:49:11 -0500 (Thu, 15 Oct 2009) $
 * @license              http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Tree helper
 *
 * Helper to generate tree representations of MPTT or recursively nested data
 */


class TreeViewHelper extends AppHelper {

    function createListTree($tree, $allowed_resources, $sluglist) {
        $out = '';

        $depth = 0;
        $prev_depth = 0;
        $count = 0;
        foreach ($tree as $id => $node) {
            $depth = strrpos($node, '|');
            if ($depth === false) {
                $depth = 0;
                $clean_node = $node;
            } else {
                $depth = $depth + 1;
                $clean_node = substr($node, strrpos($node, '|')+1);
            }

            if ($depth > $prev_depth) {
                $out .= "\n<ul>\n";
            } else if ($depth < $prev_depth) {
                for ($i = 0; $i < ($prev_depth-$depth); $i++) {
                    $out .= "</li></ul>\n";
                }
            } else if ($count>0) {
                $out .= "\n</li>\n";
            }

            $checked = '';
            if(in_array($id, $allowed_resources)){
                $checked = 'checked="checked"';
            }
            $print_label = $clean_node;
            if(isset($sluglist[$clean_node])){
                $print_label = $sluglist[$clean_node];
            }

            $out .= '<li id="node_' . $id . '" noDelete="true" noRename="true"><input type="checkbox" name="resources[]" value="'.$clean_node.'" '.$checked.'> <a class="drag" href="/positions/view/' . $id . '/' . $id . '/">' . $print_label . '</a>';
            $out .= "\n";

            $prev_depth = $depth;
            $count++;
        }
        for ($i = 0; $i < ($depth); $i++) {
            $out .= "</li></ul>\n";
        }
        if (!empty($tree)) {
            $out .= '</li>';
        }

        return $out;
    }
}