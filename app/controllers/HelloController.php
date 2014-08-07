<?php
class HelloController extends BaseController{

 public function __construct(){
 	var_dump("ゴゴゴゴ");
 }
	
 public function getIndex(){
 echo "Indexアクションです";
 }
 public function getTest(){
 echo "testアクションです";
 }
}