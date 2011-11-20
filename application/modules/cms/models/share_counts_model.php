<?php

// 
// the Share counts model
//

class Share_counts_model  extends  CI_Model {
    const table_name = 'fs_share_counts';
	
    function getCount( $url, $share_type ) {
        $query = $this->db
            ->select( 'count, updated' )
            ->from( self::table_name )
            ->where( 'url', $url )
            ->where( 'share_type', $share_type )
            ->get();
			
        if( $query->num_rows() > 0 ) {
            $result = $query->row();
            return $result->count;
        } else {
            return FALSE;
        }
    }
	
    function setCount( $url, $share_type, $count ) {
        if( $this->getCount($url, $share_type) !== FALSE ) {
            $this->db		
                ->set( 'count', $count )	
                ->where( 'url', $url )
                ->where( 'share_type', $share_type );
			
            $this->db->update( self::table_name );
        } else {
            $this->db
                ->set( 'count', $count )
                ->set( 'url', $url )
                ->set( 'share_type', $share_type )
                ->insert( self::table_name );
        }
    }
	
    function incCount( $url, $share_type ) {
        if( $this->getCount($url, $share_type) !== FALSE ) {
            $this->db		
                ->set( 'count', 'count + 1', FALSE )	
                ->where( 'url', $url )
                ->where( 'share_type', $share_type );
			
            $this->db->update( self::table_name );
        } else {
            $this->db
                ->set( 'count', 1 )
                ->set( 'url', $url )
                ->set( 'share_type', $share_type )
                ->insert( self::table_name );
        }
    }
}