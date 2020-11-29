<?php
namespace Indeed\Ihc;

class CheckRestriction
{
    /**
     * @var int
     */
    private $uid                    = 0;
    /**
     * @var bool
     */
    private $isAdmin                = false;
    /**
     * @var string
     */
    private $showOrHide             = 'block';
    /**
     * @var array
     */
    private $restrictionTarget      = [];
    /**
     * @var array
     */
    private $userLevels             = [];

    /**
     * @param none
     * @return none
     */
    public function __construct(){}

    /**
      * @param int
      * @return object
      */
    public function setUid( $input=0 )
    {
        $this->uid = $input;
        if ( !$this->uid ){
            return $this;
        }
        if ( current_user_can('administrator') ){
						$this->isAdmin = true;
						return $this;
				}
        // set levels
        $this->userLevels = \Ihc_Db::get_user_levels( $this->uid, true );
        return $this;
    }

    /**
      * @param string
      * @return object
      */
    public function setShowOrHide( $input='' )
    {
        $this->showOrHide = $input;
        return $this;
    }

    /**
      * @param array
      * @return object
      */
    public function setRestrictionTarget( $input=[] )
    {
        $this->restrictionTarget = $input;
        return $this;
    }

    /**
      * @param int
      * @return object
      */
    public function mustBlock()
    {
        // admin can see everything
        if ( $this->isAdmin ){
            return false;
        }

        // no restriction rule
        if ( $this->showOrHide == '' ){
            return false;
        }

        // no restrictions
        if ( !$this->restrictionTarget ){
            return false;
        }

        // everyone can view
        if ( $this->showForAll() ){
            return false;
        }

        if ( $this->blockForAll() ){
            return true;
        }

        // unregistered users
        if ( !$this->uid ){
            return $this->checkBlockForUnregistered();
        }


        // register users with no levels
        if ( !$this->userLevels ){
            return $this->checkBlockForRegistered();
        }

        return $this->checkBlockForUsersWithLevels();
    }

    /**
      * @param none
      * @return bool
      */
    private function showForAll()
    {
        if ( !in_array( 'all', $this->restrictionTarget ) ){
            return false;
        }
        if ( $this->showOrHide == 'show' && in_array( 'all', $this->restrictionTarget ) ){
            return true;
        }
        return false;
    }

    /**
      * @param none
      * @return bool
      */
    private function blockForAll()
    {
        if ( !in_array( 'all', $this->restrictionTarget ) ){
            return false;
        }
        if ( $this->showOrHide == 'block' && in_array( 'all', $this->restrictionTarget ) ){ // hide for
            return true;
        }
        return false;
    }

    /**
      * @param none
      * @return bool
      */
    private function checkBlockForUnregistered()
    {
        if ( $this->showOrHide == 'block' ){ // hide for
            if ( in_array( 'unreg', $this->restrictionTarget ) ){
                return true;
            } else {
                return false;
            }
        } else { // show for
            if ( in_array( 'unreg', $this->restrictionTarget ) ){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
      * @param none
      * @return bool
      */
    private function checkBlockForRegistered()
    {
        if ( $this->showOrHide == 'block' ){ // hide for
            if ( in_array( 'reg', $this->restrictionTarget ) ){
                return true;
            } else {
                return false;
            }
        } else { // show for
            if ( in_array( 'reg', $this->restrictionTarget ) ){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
      * @param none
      * @return bool
      */
    private function checkBlockForUsersWithLevels()
    {
        // register
        if ( $this->showOrHide == 'block' ){ // hide for
            if ( in_array( 'reg', $this->restrictionTarget ) ){
                return true;
            }
        } else { // show for
            if ( !in_array( 'reg', $this->restrictionTarget ) && count( $this->restrictionTarget ) == 1 &&  $this->restrictionTarget[0]=='reg' ){
                return true;
            }
        }

        // levels
        $block = false;
        $show = false;
        foreach ( $this->userLevels as $lid => $levelData ){
            if ( $this->showOrHide == 'block' ){ // hide for
                if ( in_array( $lid, $this->restrictionTarget ) ){
                    $block = true;
                } else {
                    $show = true;
                }
            } else { // show for
                if ( !in_array( $lid, $this->restrictionTarget ) ){
                    $block = true;
                } else {
                    $show = true;
                }
            }
        }

        if ( !$show && $block ){
            return $block;
        } else {
            return false;
        }
    }
}
