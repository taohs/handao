<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Forms\Element\Hidden;
class UpdateUserForm extends Form
{

    public function initialize( $entity = null, $options = null )
    {

        $mobile = new Text( 'mobile' );
        $mobile->addValidators( array(
            new PresenceOf( array(
                'message' => '电话是必须的'
            ) )
        ) );
        $this->add( $mobile );

        $name = new Text( 'name' );
        $name->addValidators( array(
            new PresenceOf( array(
                'message' => '姓名是必须的'
            ) )
        ) );
        $this->add( $name );
        $username = new Text( 'username' );
        $username->addValidators( array(
            new PresenceOf( array(
                'message' => '请输入用户名'
            ) )
        ) );
        $this->add( $username );


        $email = new Text( 'email' );
        $email->setFilters( 'email' );

        $this->add( $email );

        $uid = new Hidden( 'id' );
        $this->add( $uid );

        $user_id = new Hidden( 'user_id' );
        $this->add( $user_id );

        $address = new Text( 'address' );
        $this->add( $address );
        $province = new Text( 'province' );
        $this->add( $province );
        $city = new Text( 'city' );
        $this->add( $city );

        $area = new Text( 'area' );
        $this->add( $area );



        $license= new Text( 'license' );
        $this->add( $license );
        $number = new Text( 'number' );
        $this->add( $number );
        $models = new Text( 'models' );
        $this->add( $models );

        $year = new Text( 'year' );
        $this->add( $year );

    }

}
