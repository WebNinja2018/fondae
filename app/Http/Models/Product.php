<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Session\Session1;
use DB;
use DateTime;
use Session;

class Product extends Model
{
    protected $table = "product";
    protected $primaryKey = "productID";
    protected $fillable = array('categoryID','productName','availabilityStatus','prodcutImage','altimage','event_img','city','price', 'shortDescription','projectDescription', 'longDescription', 'producttype', 'keywordDescription', 'itemnumber', 'isActive', 'isDraft', 'tab', 'isFeatured', 'displayOrder', 'pageTitle','productDate','event_time','productExpiredDate','productStartTime','productEndTime','createdby', 'metaKeyword' , 'metaDescription', 'url_title', 'createdBy','display_page','featured_page','staff_pics_page','popular_page');
    
    public function getAllProduct($srach_categorytypeID)
    {
        $productName=Input::get('srach_name')?Input::get('srach_name'):'';
        $startDate=Input::get('startDate')? date('Y-m-d',strtotime(Input::get('startDate'))):'';
        $endDate=Input::get('endDate')? date('Y-m-d',strtotime(Input::get('endDate'))):'';
        $srch_status=Input::get('srch_status');
        $categorytypeID=$srach_categorytypeID;
        $fieldname=Input::get('fieldname')?Input::get('fieldname'):'';
        $order=Input::get('order')?Input::get('order'):'';
        $userID=Session::get('admin_user');
        $query = DB::table('product');

        $query->select('product.*','category.urlName','category.categoryName');

        if( strlen($productName) )
        {
            $query->where('product.productName','LIKE',trim($productName).'%');
        }
        if( strlen($startDate)>0 && strlen($endDate)>0)
        {
            $query->whereBetween('product.created_at', array($startDate,$endDate));
        }
        if(strlen($srch_status)>0)
        {
            $query->where('product.isActive',$srch_status);
        }
        if( strlen($categorytypeID) )
        {
            $query->where('category.categorytypeID',trim($categorytypeID));
        }
        if( $userID > 1 )
        {
            $query->where('product.createdBy',$userID);
        }
        if($fieldname=='' || $order==''){
            $query->orderBy('created_at', 'DESC');              
        }
        else
        {
            $query->orderBy($fieldname, $order);
        }

        $query->leftJoin('product_category','product.productID','=','product_category.productID');
        $query->leftJoin('category','category.categoryID','=','product_category.categoryID');   
        
        $getAllProduct=$query->paginate(50);  //With Pagination
        //$getAllProduct=$query->get();      //Without Pagination
        //echo $getAllProduct=$query->toSql();   //For Query print
        
        $result['data']=$getAllProduct;
        $result['rows']=count($getAllProduct);
        return $result;
    }
    
       function getByAttributesQuery($data)
       {
        $segment1 =  \Request::segment(1);
        $query = DB::table('product');
        if(isset($data['fieldList']))
        {
            $query->select($data['fieldList']);
        }else{
            $query->select('product.*','category.urlName','category.categoryName');
        }
        if(isset($data['productID']) && strlen(intval($data['productID'])) > 0)
        {
            $query->where('product.productID',intval($data['productID']));
        }
        if(isset($data['categoryID']) && strlen(intval($data['categoryID'])) > 0)
        {
            $query->where('product.categoryID',intval($data['categoryID']));
        }
        if(isset($data['productName']) && strlen(trim($data['productName'])) > 0)
        {
            $query->where('product.productName',trim($data['productName']));
        }
        if(isset($data['srachProductName']) && strlen(trim($data['srachProductName'])) > 0)
        {
            $query->where('product.productName','LIKE','%'.trim($data['srachProductName']).'%');
        }
        if(isset($data['availabilityStatus']) && strlen(trim($data['availabilityStatus'])) > 0)
        {
            $query->where('product.availabilityStatus',trim($data['availabilityStatus']));
        }
        if(isset($data['prodcutImage']) && strlen(trim($data['prodcutImage'])) > 0)
        {
            $query->where('product.prodcutImage',trim($data['prodcutImage']));
        }
        if(isset($data['event_img']) && strlen(trim($data['event_img'])) > 0)
        {
            $query->where('product.event_img',trim($data['event_img']));
        }
        if(isset($data['altimage']) && strlen(trim($data['altimage'])) > 0)
        {
            $query->where('product.altimage',trim($data['altimage']));
        }
        if(isset($data['city']) && strlen(trim($data['city'])) > 0)
        {
            $query->where('product.city',trim($data['city']));
        }
        if(isset($data['price']) && strlen(trim($data['price'])) > 0)
        {
            $query->where('product.price',trim($data['price']));
        }
        if(isset($data['shortDescription']) && strlen(trim($data['shortDescription'])) > 0)
        {
            $query->where('product.shortDescription',trim($data['shortDescription']));
        }
        if(isset($data['projectDescription']) && strlen(trim($data['projectDescription'])) > 0)
        {
            $query->where('product.projectDescription',trim($data['projectDescription']));
        }
        if(isset($data['longDescription']) && strlen(trim($data['longDescription'])) > 0)
        {
            $query->where('product.longDescription',trim($data['longDescription']));
        }
        if(isset($data['producttype']) && strlen(intval($data['producttype'])) > 0)
        {
            $query->where('product.producttype',intval($data['producttype']));
        }
        if(isset($data['keywordDescription']) && strlen(trim($data['keywordDescription'])) > 0)
        {
            $query->where('product.keywordDescription',trim($data['keywordDescription']));
        }
        if(isset($data['itemnumber']) && strlen(trim($data['itemnumber'])) > 0)
        {
            $query->where('product.itemnumber',trim($data['itemnumber']));
        }
        if(isset($data['isActive']) && strlen(intval($data['isActive'])) > 0)
        {
            $query->where('product.isActive',intval($data['isActive']));
        }
        if(isset($data['isFeatured']) && strlen(intval($data['isFeatured'])) > 0)
        {
             $query->where('product.isFeatured',intval($data['isFeatured']));
        }
        if(isset($data['displayOrder']) && strlen($data['displayOrder']) > 0)
        {
            $query->where('product.displayOrder',intval($data['displayOrder']));
        }

        if(isset($data['featured_page']) && strlen($data['featured_page']) > 0)
        {
            $query->where('product.featured_page',intval($data['featured_page']));
        }

         if(isset($data['staff_pics_page']) && strlen($data['staff_pics_page']) > 0)
        {
            $query->where('product.staff_pics_page',intval($data['staff_pics_page']));
        }

         if(isset($data['popular_page']) && strlen($data['popular_page']) > 0)
        {
            $query->where('product.popular_page',intval($data['popular_page']));
        }

         if(isset($data['display_page']) && strlen($data['display_page']) > 0)
        {
            $query->where('product.display_page',intval($data['display_page']));
        }

    
        if($segment1=='recentpast')
        {
           $query->whereBetween('product.productDate', array(date('Y-m-d', strtotime('-20 day')),date('Y-m-d', strtotime('-1 day'))));
        }
        elseif($segment1=='completedprojects')
        {
            $query->where('product.productDate','<',date('Y-m-d', strtotime('-20 day')));
        }
        else
        {
            $query->where('product.productDate','>=',date('Y-m-d'));
        }
    if(isset($data['productExpiredDate']) && strlen(intval($data['productExpiredDate'])) > 0)
        {
            $query->where('product.productExpiredDate','>=',new DateTime('today'));
        }
    if(isset($data['productDate']) && strlen(intval($data['productDate'])) > 0)
        {
            $query->where('product.productDate',$data['productDate']);
        }

        if(isset($data['event_time']) && strlen(intval($data['event_time'])) > 0)
        {
            $query->where('product.event_time',$data['event_time']);
        }

        

    if(isset($data['pageTitle']) && strlen(trim($data['pageTitle'])) > 0)
        {
            $query->where('product.pageTitle',trim($data['pageTitle']));
        }
        if(isset($data['metaKeyword']) && strlen(trim($data['metaKeyword'])) > 0)
        {
            $query->where('product.metaKeyword',trim($data['metaKeyword']));
        }
        if(isset($data['metaDescription']) && strlen(trim($data['metaDescription'])) > 0)
        {
            $query->where('product.metaDescription',trim($data['metaDescription']));
        }
        if(isset($data['url_title']) && strlen(trim($data['url_title'])) > 0)
        {
            $query->where('product.url_title',trim($data['url_title']));
        }
        if(isset($data['createdBy']) && strlen($data['createdBy']) > 0)
        {
             $query->where('product.createdBy',intval($data['createdBy']));
        }
        if(isset($data['product_url']) && strlen(trim($data['product_url'])) > 0)
        {
           $query->where('product.product_url',trim($data['product_url']));
        }
        if(isset($data['created_at']) && strlen($data['created_at']) > 0)
        {
            $query->where('product.created_at',$data['created_at']);
        }
        if(isset($data['updated_at']) && strlen($data['updated_at']) > 0)
        {
            $query->where('product.updated_at',$data['updated_at']);
        }
        if(isset($data['productCategoryUrlName']) && strlen(trim($data['productCategoryUrlName'])) > 0)
        {
            $query->where('category.urlName',$data['productCategoryUrlName']);
        }
        if(isset($data['categoryisActive']) && strlen(trim($data['categoryisActive'])) > 0)
        {
            $query->where('category.isActive',$data['categoryisActive']);
        }
        if(isset($data['categorytypeID']) && strlen(trim($data['categorytypeID'])) > 0)
        {
            $query->where('category.categorytypeID',$data['categorytypeID']);
        }
        //if(isset($data['orderBy']) && strlen(trim($data['orderBy'])) > 0)
//        {
//          if(isset($data['order']) && strlen(trim($data['order'])) > 0)
//          {
//                  $query->orderBy($data['orderBy'],$data['order']);
//          }else{
//              $query->orderBy($data['orderBy']);
//          }
//      }else{
//          $query->orderBy('product.productDate','ASC');
//      }
        $query->orderBy('product.productDate','ASC');
        if(isset($data['groupBy']) && strlen(trim($data['groupBy'])) > 0)
        {
            $query->groupBy($data['groupBy']);
        }
        $query->leftJoin('product_category','product.productID','=','product_category.productID');
        $query->leftJoin('category','category.categoryID','=','product_category.categoryID');   
        $query->leftJoin('product_staff','product_staff.productID','=','product.productID');
        
        //echo $getAllStaff=$query->toSql();exit;
        if(isset($data['paginate']) && strlen(trim($data['paginate'])) > 0)
        {
            $result['data']=$query->paginate(intval($data['paginate']));
        }else{
            $result['data']=$query->get();
        }
        $result['recordCount'] = count($result['data']);
        return $result;
    }
}
