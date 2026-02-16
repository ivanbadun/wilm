<?php
/**
 * Extend WordPress search to include custom fields
 *
 * Uses EXISTS subquery instead of JOIN to avoid cartesian product
 * performance issues when searching postmeta.
 *
 * Uses posts_search filter which provides:
 * - The search SQL portion specifically (cleaner than full WHERE)
 * - Access to WP_Query object to get search term (no regex extraction needed)
 */

/**
 * Add EXISTS subquery to search meta_value without JOIN
 *
 * @param string   $search The search SQL for the WHERE clause.
 * @param WP_Query $query  The current WP_Query instance.
 * @return string Modified search SQL.
 */
function search_postmeta_exists( $search, $query ) {
    global $wpdb;

    // Only modify if there's a search term
    $search_term = $query->get( 's' );
    if ( empty( $search_term ) || empty( $search ) ) {
        return $search;
    }

    // Escape for LIKE query (adds backslashes to % and _)
    $like_term = '%' . $wpdb->esc_like( $search_term ) . '%';

    // Build EXISTS subquery - no JOIN, no cartesian product
    $exists_sql = $wpdb->prepare(
        " OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID AND {$wpdb->postmeta}.meta_value LIKE %s)",
        $like_term
    );

    // Append to existing search clause (before the closing parenthesis)
    // $search looks like: " AND (((post_title LIKE '%term%') OR ...))"
    // We insert our EXISTS before the final ))
    $search = preg_replace( '/\)\s*\)\s*$/', $exists_sql . '))', $search );

    return $search;
}

add_filter( 'posts_search', 'search_postmeta_exists', 10, 2 );
