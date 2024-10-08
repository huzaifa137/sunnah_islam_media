<?php

namespace App\Http\Controllers;


use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Stroage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\contact;
use App\Models\sheikh;
use App\Models\Adhkar;
use App\Models\Audio;
use App\Models\video;
use App\Models\Quran;
use App\Models\Admin;
use App\Models\Serie;
use App\Models\Book;
use Carbon\Carbon;


class BookController extends Controller
{
        public function store(Request $request){

            $request->validate([
                'author_name'=>'required',
                'book_name'=>'required',
                'Catagory'=>'required',
                'language'=>'required',
                'format'=>'required',
                'pages'=>'required',
                'Edition'=>'required',
                'Summary'=>'required',
                'Topics'=>'required',
                'Book_image'=>'required|mimes:jpeg,jpg,png,bmp',
                'Book_pdf'=>'required|mimes:pdf,zip'
            ]);
            
            $post = new Book();            
            
            $post->Author_Name=$request->author_name;
            $post->Book_Name=$request->book_name;
            $post->Catagory=$request->Catagory;
            $post->Language=$request->language;
            $post->Format=$request->format;
            $post->pages=$request->pages;
            $post->Edition=$request->Edition;
            $post->Summary=$request->Summary;
            $post->Topics=$request->Topics;

            if($request->file('Book_image'))
             {
            $file=$request->file('Book_image');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/BookImage'),$filename);
            $post['Book_image']=$filename;
            }

            $file=$request->Book_pdf;
            $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
		    $file->move('assets_7',$filename);
            $post->Book_pdf=$filename;


            $save=$post->save();

            if($save)
            {   
                return redirect('AllBooks')->with('success','Book has been Added successfully');
            }
        }

        public function show()
        {
            $data = Book::all();

            return view('Adminpages.AllBooks',compact(['data']));
        }

        public function delete($id)
        {
            $data = Book::find($id);
            $data->delete();

            return redirect()->back();
        }

        public function updateRecord($id,Request $request)
        {
              $info = Book::find($id);

             return view('Adminpages.EditBook',compact(['info']));
        }


        public function update(Request $request)
        {
            $post = Book::find($request->id);

            $request->validate([
                'author_name'=>'required',
                'book_name'=>'required',
                'Catagory'=>'required',
                'language'=>'required',
                'format'=>'required',
                'pages'=>'required',
                'Edition'=>'required',
                'Summary'=>'required',
                'Topics'=>'required',
                'Book_image'=>'required|mimes:jpeg,jpg,png,bmp',
                'Book_pdf'=>'required|mimes:pdf,zip'
            ]);
                
            
            $post->Author_Name=$request->author_name;
            $post->Book_Name=$request->book_name;
            $post->Catagory=$request->Catagory;
            $post->Language=$request->language;
            $post->Format=$request->format;
            $post->pages=$request->pages;
            $post->Edition=$request->Edition;
            $post->Summary=$request->Summary;
            $post->Topics=$request->Topics;

            $save=$post->save();

            if($request->file('Book_image'))
             {
            $file=$request->file('Book_image');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/BookImage'),$filename);
            $post['Book_image']=$filename;
            }
            
            $file=$request->Book_pdf;
            $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
		    $file->move('assets_7',$filename);
            $post->Book_pdf=$filename;

            $save=$post->save();

            if($save)
            {   
                return redirect('AllBooks')->with('success','Book has been Updated successfully');
            }
            
        }

        public function home()
        {
            
            $new_release = DB::table('books')->orderByDesc('id')->paginate(8);
            return view('pages.home',compact(['new_release']));
        }

        public function AllBooksHome()
        {
             $data = Book::paginate(9);
             return view('gridviews.Books',compact(['data']));
        }

        // Arabic , Luganda, English books collection.

        public function ArabicBooks()
        {
            $data = Book::where('Language','اللغة العربية')->paginate(9);
            return view('gridviews.ArabicBooks',compact(['data']));
        }

        public function EnglishBooks()
        {
            $data = Book::where('Language','English')->paginate(9);
            return view('gridviews.EnglishBooks',compact(['data']));
        }

        public function LugandaBooks()
        {
            $data = Book::where('Language','Luganda')->paginate(9);
            return view('gridviews.EnglishBooks',compact(['data']));
        }

        //Last , final page ---> view, download, find similar books.

        public function lastPage($id)
        {
            $data = Book::find($id);
            return view('pages.book_details',compact(['data']));
        }

        public function search_lastpage($id)
        {
            $data = Book::find($id);
            return view('pages.book_details',compact(['data']));
        }

        public function about_us()
        {
            $data = Book::paginate(4);
            return view('gridviews.about',compact(['data']));
        }

        public function download(Request $request,$Book_pdf)
        {
            return response()->download(public_path('assets_7/'.$Book_pdf));
        }


        public function view($id)
        {
            $data = Book::find($id);
            return view('pages.ViewBook',compact(['data']));
        }

        public function login()
        {
            return view('login');
        }

        public function register()
        {
            return view('register');
        }

        public function store1(Request $request)
        {
            $request->validate([
                'fname'=>'required',
                'email'=>'required|unique:admins',
                'phonenumber'=>'required|unique:admins',
                'password'=>'required|min:5',
                'confirm_password'=>'required'
            ]);

        $password1=$request->input('password');
        $password2=$request->input('confirm_password');

        if(strcmp($password1,$password2)!=0)
        {
            return back()->withInput()->with('fail', 'Password entered do not match');
        }

        $post = new Admin();
        $post->fname = $request->fname;
        $post->email = $request->email;
        $post->phonenumber = $request->phonenumber;
        $post->password =Hash::make($request->password);

        $save = $post->save();

        if($save)
        {
            return back()->with('success','Account created Successfully')
            ->with('fail','Account waiting for Activation');
        }
        else
        {
            return back()->with('fail','Failed to create account');
        }
            
        }

        public function pass(Request $request){

            if($userInfo = Admin::all()
            ->where('phonenumber','=',$request->phonenumber)
            ->where('status','=','invalid')
            ->first())
            {
                return back()->with('fail','Account not activated');    
            } 

            $userInfo = Admin::where('phonenumber','=',$request->phonenumber)->first();
            if(Hash::check($request->password,$userInfo->password))
                    {  
                    $request->session()->put('LoggedUser',$userInfo->id); 
                    return redirect('Adminpages.Dashboard');
                    }
            else     
                    {
                    return back()->with('fail','incorrect email or password'); 
                    }
        }

        public function verify(Request $request)
        {
            $request->validate([
                'phonenumber'=>'required',
                'password'=>'required|min:5',
            ]);

            $userInfo = Admin::where('phonenumber','=',$request->phonenumber)->first();

            if(!$userInfo)
            {
                return back()->with('fail','incorrect phonenumber or password');
            }
            else{
                return $this->pass($request);
            }
        }

        public function logout()
        {
            if(session()->has('LoggedUser'))
            {
                session()->pull('LoggedUser');
                return redirect('auth.login');
            }
        }

        public function dashboard()
        {
            $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

            $all = DB::table('books')->count();
            $luganda = Book::where('Language','luganda')->count();
            $arabic = Book::where('Language','اللغة العربية')->count();
            $english = Book::where('Language','english')->count();

            return view('Adminpages.Dashboard',compact(['data','all','arabic','luganda','english']));
        }

        public function contact_info()
        {
             $info = DB::table('contacts')->orderByDesc('id')->paginate(2);


             return view('Adminpages.info_contact',compact(['info']));
        }

        public function SendMessage(Request $request)
        {

            $request->validate([
                'firstname'=>'required',
                'lastname'=>'required',
                'email'=>'required',
                'phonenumber'=>'required'
            ]);
            
            $post = new contact();

            $post->FirstName=$request->firstname;
            $post->LastName=$request->lastname;
            $post->Email=$request->email;
            $post->PhoneNumber=$request->phonenumber;
            $post->Message=$request->message;
          
            $post->save();

           return redirect()->back()->with('success','Message has been sent to Sunnah Islam Media');

        }

        public function fetchRecords($value)
        {
             return redirect('search/'.$value);
        }

        public function SearchBar(Request $request)
        {
             $keyword =$request->keyword;
             $catagory1 =$request->Catagory1;
             $catagory2 =$request->Catagory2;

            if($keyword != null && $catagory1 == null && $catagory2 == null)
            {   
                
                $data = Book::paginate(3);

                $finalresult =  DB::table('books')->where('Catagory', 'like', '%'.$keyword.'%')
                                                  ->orWhere('Author_Name', 'like', '%'.$keyword.'%')
                                                  ->orWhere('Book_Name', 'like', '%'.$keyword.'%')
                                                  ->paginate(150);
              
               return view('gridviews.result',compact(['finalresult','data']));
            }
            else if($keyword == null && $catagory1 != null && $catagory2 == null)
            {
                $value = $catagory1;
                return $this->fetchRecords($value);
            }

            else if($keyword == null && $catagory1 == null && $catagory2 != null)
            {
                $value = $catagory2;
                return $this->fetchRecords($value);
            }
            else if($keyword == null && $catagory1 == null && $catagory2 == null){
                
                
                $data = Book::paginate(3);
                $finalresult= DB::table('books')->where('Catagory', '')->get();
                return view('gridviews.result1',compact(['finalresult','data']));
            }

            else if($keyword == null && $catagory1 != null && $catagory2 != null){
                
                if($catagory1 === $catagory2)
                {
                    $value = $catagory2;
                    return $this->fetchRecords($value);
                }
                
                $data = Book::paginate(3);
                $catagory1 = collect(DB::table('books')->where('Catagory',$catagory1)->get());
                $catagory2 = collect(DB::table('books')->where('Catagory',$catagory2)->get());
                
                $result=$catagory1->merge($catagory2);
                $finalresult = $result->all();

                return view('gridviews.result1',compact(['finalresult','data']));
            }
            else{

                if($catagory1 === $catagory2)
                {
                    $keyword = collect(DB::table('books')->where('Catagory', 'like', '%'.$keyword.'%')
                                ->orWhere('Author_Name', 'like', '%'.$keyword.'%')
                                ->orWhere('Book_Name', 'like', '%'.$keyword.'%')->get());      

                    $catagory1 = collect(DB::table('books')->where('Catagory',$catagory1)->get());

                    $data = Book::paginate(3);
                    $result=$keyword->merge($catagory1);
                    $finalresult = $result->all();

                    return view('gridviews.result1',compact(['finalresult','data']));
                }
   
                $keyword = collect(DB::table('books')->where('Catagory', 'like', '%'.$keyword.'%')
                                ->orWhere('Author_Name', 'like', '%'.$keyword.'%')
                                ->orWhere('Book_Name', 'like', '%'.$keyword.'%')->get());      

                 $catagory1 = collect(DB::table('books')->where('Catagory',$catagory1)->get());
                 $catagory2 = collect(DB::table('books')->where('Catagory',$catagory2)->get());
                
               
                $data = Book::paginate(3);
                
                $all=$keyword->merge($catagory1);
                $result=$all->merge($catagory2);

                 $finalresult = $result->all();
     
                return view('gridviews.result1',compact(['finalresult','data']));

            }
    
        }
       
        public function searchInfo($keyword)
        {
            $data = Book::paginate(3);
            $finalresult = Book::where('Catagory',$keyword)->paginate(9);
            return view('gridviews.result',compact(['finalresult','data']));
        }

        public function search_Scholar($keyword)
        {
    
            $data = Book::paginate(3);
            $finalresult = Book::where('Author_Name',$keyword)->paginate(9);
            return view('gridviews.result',compact(['finalresult','data']));
        }

        // DUA AND ADHKAR SECTION

        public function add_post(Request $request)
        {
            $request->validate([
                'dua_name'=>'required',
                'dua_catagory'=>'required',
                'number_in_words'=>'required',
                'number_in_figures'=>'required',
                'para_1'=>'required',
                'para_2'=>'required',
                'para_3'=>'required',
                'para_4'=>'required',
                'para_5'=>'required',
                'para_6'=>'required',
                'para_7'=>'required',
                'Adhkar_image'=>'required|mimes:jpeg,jpg,png,bmp'
            ]);

            $post = new Adhkar();
            $post->dua_name=$request->dua_name;
            $post->dua_catagory=$request->dua_catagory;
            $post->number_in_words=$request->number_in_words;
            $post->number_in_figures=$request->number_in_figures;
            $post->para_1=$request->para_1;
            $post->para_2=$request->para_2;
            $post->para_3=$request->para_3;
            $post->para_4=$request->para_4;
            $post->para_5=$request->para_5;
            $post->para_6=$request->para_6;
            $post->para_7=$request->para_7;

            if($request->file('Adhkar_image'))
             {
            $file=$request->file('Adhkar_image');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/Adhkar_image'),$filename);
            $post['Adhkar_image']=$filename;
            }

            $save=$post->save();

            if($save)
            {   
                return redirect('AllAdhkar')->with('success','Adhkar has been Added successfully');
            }
        }

        public function morning_adhkar()
        {

            $data = Adhkar::where('dua_catagory','MORNING')->get();
            return view('Adhkar.morning',compact(['data']));
        }

        public function evening_adhkar()
        {
            $data = Adhkar::where('dua_catagory','EVENING')->get();
            return view('Adhkar.evening',compact(['data']));
        }

        public function Adhkar_After_Swalah()
        {
            $data = Adhkar::where('dua_catagory','Adhkar After Swalah')->get();
            return view('Adhkar.AdhkarAfterSwalah',compact(['data']));
        }

        public function Famous_Duas_from_the_Quran()
        {
            $data = Adhkar::where('dua_catagory','Famous Duas From Quran')->get();
            return view('Adhkar.FamousQuranicDuas',compact(['data']));
        }

        public function Other_Duas()
        {
            $data = Adhkar::where('dua_catagory','Other Duas')->get();
            return view('Adhkar.Other_Duas',compact(['data']));
        }

        public function adhkarDetails($id)
        {
            $data = Adhkar::find($id);
            return view('Adhkar.adhkarDetails',compact(['data']));
        }

        public function ShowAllAdhkar()
        {
            $data = Adhkar::all();
            return view('Adhkar.AllAdhkar',compact(['data']));
        }

        public function deleteAdhkar($id)
        {
             $data = Adhkar::find($id);
             $data->delete();

             return redirect('AllAdhkar')->with('success','Adhkar has been deleted successfully');
        }


        public function EditAdhkar($id)
        {
            $data =  Adhkar::find($id);

            return view('Adhkar.EditAdhkar',compact(['data']));
        }

        public function updateAdhkar(Request $request)
        {
             $post = Adhkar::find($request->id);

            $request->validate([
                'dua_name'=>'required',
                'dua_catagory'=>'required',
                'number_in_words'=>'required',
                'number_in_figures'=>'required',
                'para_1'=>'required',
                'para_2'=>'required',
                'para_3'=>'required',
                'para_4'=>'required',
                'para_5'=>'required',
                'para_6'=>'required',
                'para_7'=>'required',
                'Adhkar_image'=>'required|mimes:jpeg,jpg,png,bmp'
            ]);

       
            $post->dua_name=$request->dua_name;
            $post->dua_catagory=$request->dua_catagory;
            $post->number_in_words=$request->number_in_words;
            $post->number_in_figures=$request->number_in_figures;
            $post->para_1=$request->para_1;
            $post->para_2=$request->para_2;
            $post->para_3=$request->para_3;
            $post->para_4=$request->para_4;
            $post->para_5=$request->para_5;
            $post->para_6=$request->para_6;
            $post->para_7=$request->para_7;

            if($request->file('Adhkar_image'))
             {
            $file=$request->file('Adhkar_image');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/Adhkar_image'),$filename);
            $post['Adhkar_image']=$filename;
            }

            $save=$post->save();

            if($save)
            {   
                return redirect('AllAdhkar')->with('success','Adhkar has been Updated successfully');
            }
        }

        // AUDIO PAGE 

        public function AudioPage(){

            $UgandanSheikhs = Audio::select('First_name','sheikh_name')->distinct()->get();
            
            return view('Audio.UgandanAudios',compact(['UgandanSheikhs']));
        }


        public function IndividualSheikh(){

            return view('Audio.IndvidualSheikh');
        }


        public function AudioUpload(){

            $all_sheikhs = sheikh::all();
            $all_series =  Serie::all();

            return view('Audio.UploadAudio',compact(['all_sheikhs','all_series']));
        }


        public function UploadAudio(Request $request){

        $First_name=$request->First_name;
        $sheikh_name=$request->sheikh_name;

        $firstname = DB::table('sheikhs')->where('Fullname','=',$sheikh_name)->value('Firstname');
        $sheikh_id = DB::table('sheikhs')->where('Fullname','=',$sheikh_name)->value('id');
        
        $post = new Audio();
        
        $post->First_name=$firstname;
        $post->sheikh_name=$request->sheikh_name;
        $post->topic=$request->topic;
        $post->sheikh_id=$sheikh_id;
        $post->serie_id = $request->serie_name;

        //Storing an Audio
        $file=$request->audio;
        $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
		$file->move('audioz',$filename);
        $post['audio']=$filename;

        $save=$post->save();

        if($save)
        {   
            return redirect()->back()->with('success','Audio has been Added successfully');
            
        }
     }

    
    
    public function SheikhLectures(Request $request, $name)
    {
        $sheikhId = Sheikh::where('Firstname', $name)->value('id');
        $sheikhFullname = Sheikh::where('Firstname', $name)->value('Fullname');
    
        $SheikhSeries = Audio::select('serie_id')->where('sheikh_id', $sheikhId)->distinct()->get();
    
        $Serienames = [];
         foreach ($SheikhSeries as $seriename) {
            $seriesRecord = DB::table('series')
                ->select('serieId', 'serieName')
                ->where('serieId', $seriename->serie_id)
                ->first();
                
            if ($seriesRecord) {
                $Serienames[] = $seriesRecord;
            }
        }
    
        return view('Audio.IndvidualSheikhSeries', compact(['Serienames', 'sheikhFullname', 'name', 'sheikhId']));
    }



     public function SheikhLecturesSeries($sheikhId,$serieId){

        $name = Sheikh::where('id',$sheikhId)->value('Firstname');
        $Seriename = Serie::where('serieId',$serieId)->value('serieName');
        $SheikhAudios = Audio::where('sheikh_id',$sheikhId)
                              ->where('serie_id',$serieId)->get();

        return view('Audio.IndvidualSheikh', compact(['Seriename','name','SheikhAudios']));
        
     }

     public function downloadAudio(Request $request,$audio){
            return response()->download(public_path('audioz/'.$audio));
    }

    public function AllAudios(){

        $data = Audio::all();
        return view('Audio.AllAudio',compact(['data']));
    }

    public function EditAudio(Request $request)
    {
        $data = Audio::find($request->id);
        return view('Audio.EditAudio',compact(['data']));
    }

    public function EditQuran(Request $request)
    {
        $data = Quran::find($request->id);
        return view('Quran.EditQuran',compact(['data']));
    }


    public function UpdateQuranAudio(Request $request)
    {

        $request->validate([
            'SurahName'=>'required',
            'ScholarName'=>'required',
            'QuranAudio'=>'required|file|mimes:mp3,ogg',
        ]);

        $post = Quran::find($request->id);
        
        $post->SurahName = $request->SurahName;
        $post->ScholarName = $request->ScholarName;
        $file = $request->QuranAudio;

        $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
        $file->move('quran_audios',$filename);
        $post['QuranAudio']=$filename;
        
        $save=$post->save();
       
        if($save){
            return redirect('All-Quran')->with('success','Quran Audio has been updated successfully');
        }
        else{
            echo "Data has not been stored !!!";
        }
    }

    public function UpdateAudio(Request $request)
    {
        $request->validate([
            'First_name'=>'required',
            'sheikh_name'=>'required',
            'topic'=>"required",
            'audio'=>'required|file|mimes:mp3,ogg',
        ]);

     
    $post = Audio::find($request->id);
    
    $post->First_name=$request->First_name;
    $post->sheikh_name=$request->sheikh_name;
    $post->topic=$request->topic;

    //Storing an Audio
    $file=$request->audio;
    $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
    $file->move('audioz',$filename);
    $post['audio']=$filename;

    $save=$post->save();

    if($save)
    {   
        return redirect('All-Audio')->with('success','Audio has been Updated successfully');
    }
    }

    public function deleteAudio($id)
    {
        $data = Audio::find($id);
        $data->delete();
        
        return redirect('All-Audio')->with('success','Audio has been deleted successfully');
    }


    public function deleteQuran($id)
    {
        $data = Quran::find($id);
        $data->delete();
        
        return redirect('All-Quran')->with('success','Quran Audio has been deleted successfully');
    }

// Video Configurations.

    public function AllVideos(){
        
        $data = video::all();
        return view('Videos.AllVideos',compact(['data']));
    }

    public function AdminVideos(){

        $data = Video::all();
        return view('Videos.AllAdminVideos',compact(['data']));
    }


    public function VideoDetails(){
        return view('Videos.VideoDetails');
    }

    public function AddVideo(){

        $all_sheikhs = sheikh::all();

        return view('Videos.AddVideo',compact(['all_sheikhs']));
    }

    public function EditVideo(Request $request)
    {
        $data = Video::find($request->id);
        return view('Videos.EditVideo',compact(['data']));
    }

    
    public function deleteVideo($id){
        $data = Video::find($id);
        $data->delete();

        return redirect()->back()->with('success','Video has been deleted successfully');
    }

    public function UpdateVideo(Request $request){

        $request->validate([
            'sheikh_name'=>'required',
            'topic'=>'required',
            'Summary'=>'required',
            'video_link'=>'required',
            'Catagory'=>'required',
        ]);

        $post = Video::find($request->id);

        $post->sheikh_name = $request->sheikh_name;
        $post->topic = $request->topic;
        $post->Summary = $request->Summary;
        $post->video_link = $request->video_link;
        $post->Catagory=$request->Catagory;
        $post->save();

        return redirect('All-videos')->with('success','Video has been Updated successfully');

    }


    public function uploadVideo(Request $request){

        $request->validate([
            'sheikh_name'=>'required',
            'topic'=>'required',
            'Summary'=>'required',
            'video_link'=>'required',
            'Catagory'=>'required',
        ]);

        $post = new video();

        $post->sheikh_name = $request->sheikh_name;
        $post->topic = $request->topic;
        $post->Summary = $request->Summary;
        $post->video_link = $request->video_link;
        $post->Catagory=$request->Catagory;
        $post->save();

        return redirect()->back()->with('success','Video has been uploaded successfully');
    }


    public function SearchSubject($keyword)
    {
        $finalresult = video::where('Catagory',$keyword)->get();
        return view('Videos.CatagoryResult',compact(['finalresult']));
    }

    public function SearchSheikh($keyword){

        $finalresult =  DB::table('videos')->where('sheikh_name', 'like', '%'.$keyword.'%')->get();
        return view('Videos.CatagoryResult2',compact(['finalresult']));
    }


    public function WatchVideo($id)
    {
        $data = video::find($id);
        return view('Videos.VideoDetails',compact(['data']));
    }


    public function SearchBarVideo(Request $request)
    {
             $keyword =$request->keyword;
             $catagory1 =$request->Catagory1;
             $catagory2 =$request->Catagory2;

            if($keyword != null && $catagory1 == null && $catagory2 == null)
            {   
                
                $data = video::paginate(3);

                $finalresult =  DB::table('videos')->where('Catagory', 'like', '%'.$keyword.'%')
                                                  ->orWhere('sheikh_name', 'like', '%'.$keyword.'%')
                                                  ->paginate(500);
              
               return view('Videos.CatagoryResult',compact(['finalresult']));
            }
            else if($keyword == null && $catagory1 != null && $catagory2 == null)
            {
                $value = $catagory1;
                return $this->fetchRecordsVideo($value);
            }

            else if($keyword == null && $catagory1 == null && $catagory2 != null)
            {
                $value = $catagory2;
                return $this->fetchRecordsVideo($value);
            }
            else if($keyword == null && $catagory1 == null && $catagory2 == null){
                
                $finalresult= DB::table('videos')->get();
                return view('Videos.CatagoryResult',compact(['finalresult']));
            }

            else if($keyword == null && $catagory1 != null && $catagory2 != null){
                
                if($catagory1 === $catagory2)
                {
                     $value = $catagory2;
                    return $this->fetchRecordsVideo($value);
                }
                
                $catagory1 = collect(DB::table('videos')->where('Catagory',$catagory1)->get());
                $catagory2 = collect(DB::table('videos')->where('Catagory',$catagory2)->get());
                
                $result=$catagory1->merge($catagory2);
                $finalresult = $result->all();

                return view('Videos.CatagoryResult',compact(['finalresult']));
            }
            else{

                if($catagory1 === $catagory2)
                {
                    $keyword = collect(DB::table('videos')->where('Catagory', 'like', '%'.$keyword.'%')
                                ->orWhere('sheikh_name', 'like', '%'.$keyword.'%')->get());      

                    $catagory1 = collect(DB::table('videos')->where('Catagory',$catagory1)->get());

                    $result=$keyword->merge($catagory1);
                    $finalresult = $result->all();

                    return view('Videos.CatagoryResult',compact(['finalresult']));
                }
   
                $keyword = collect(DB::table('videos')->where('Catagory', 'like', '%'.$keyword.'%')
                                ->orWhere('sheikh_name', 'like', '%'.$keyword.'%')->get());      

                 $catagory1 = collect(DB::table('videos')->where('Catagory',$catagory1)->get());
                 $catagory2 = collect(DB::table('videos')->where('Catagory',$catagory2)->get());
                
                $all=$keyword->merge($catagory1);
                $result=$all->merge($catagory2);

                 $finalresult = $result->all();
     
                 return view('Videos.CatagoryResult',compact(['finalresult']));

            }
        }

        public function fetchRecordsVideo($value)
        {
             return redirect('search/subject/'.$value);
        }

        public function carbonDate(){

            $dt = Carbon::now();
            echo $dt->toHijri()->isoFormat('LL');
        }
    
        //Implementation of Quran

        public function QuranAudio(){
            return view('Quran.QuranAudio');
        }

        public function SpecificReciter($name){
            
            $IndividualQuranReciters = Quran::where('ScholarName',$name)->get();
            
            return view('Quran.Surah',compact(['IndividualQuranReciters','name']));
        }


        public function AddQuran(){
            return view('Quran.UploadQuran');
        }

        public function UploadQuranAudio(Request $request){

            $request->validate([
                'SurahName'=>'required',
                'ScholarName'=>'required',
                'QuranAudio'=>'required|file|mimes:mp3,ogg',
            ]);

            $post = new Quran();  

            $post->SurahName = $request->SurahName;
            $post->ScholarName = $request->ScholarName;

            $file = $request->QuranAudio;
            $filename=date('YmdHi').'.'.$file->getClientOriginalExtension();
            $file->move('quran_audios',$filename);
            $post['QuranAudio']=$filename;
            
            $save=$post->save();
           
            if($save){
                return redirect('All-Quran')->with('success','Quran Audio has been uploaded successfully');
            }
            else{
                echo "Data has not been stored !!!";
            }
        }

        public function downloadQuran(Request $request,$audio){
            return response()->download(public_path('quran_audios/'.$audio));
        }

        public function AllQuran(){

            $data = Quran::all();

            return view('Quran.AllQuran',compact(['data']));
        }

        public function AllSheikhs()
        {
            $data = sheikh::all();
            return view('Audio.AllSheikhs',compact(['data']));
        }

        public function AddSheikh()
        {
            return view('Audio.AddSheikh');
        }

        public function StoreSheikh(Request $request)
        {   
            $request->validate([
                'First_name'=>'required',
                'full_name'=>'required',
            ]);

            $post = new sheikh();
            $post->Firstname = $request->First_name;
            $post->Fullname = $request->full_name;
            $post->save();

            return redirect('All-Sheikhs')->with('success','Sheikh has been Added successfully');
        }

        public function DeleteSheikh($id)
        {

            $data = sheikh::find($id);
            $data->delete();

            $delete_record = DB::table('audio')->where('sheikh_id',$id)->delete();

            return redirect()->back()->with('success','Record has been deleted successfully');
        }

        public function EditSheikhInfo($id)
        {
              $info = sheikh::find($id);

              return view('Adminpages.EditSheikh',compact(['info']));
        }

        public function UpdateSheikhInfo(Request $request)
        {
            $record_id = $request->record_id;

            $post = sheikh::find($record_id);

            $post->Firstname = $request->First_name;
            $post->Fullname = $request->full_name;
            $post->save();

            DB::table('audio')  
                            ->where('sheikh_id',$record_id)
                            ->update(['First_name' => $post->Firstname,
                                      'sheikh_name' => $post->Fullname,
                            ]);
           
            
            return redirect('All-Sheikhs')->with('success','Sheikh Information has been updated successfully');
        }


    public function userInformation()
    {
        $users = Admin::all();

        $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        return view('Adminpages.user-information',compact(['data','users']));
    }

    public function editUser($id)
    {
        $userRecord = Admin::find($id);

        $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        return view('Adminpages.edit-user-information',compact(['data','userRecord']));
    }

    public function updateUserData(Request $request)
    {
        $userrecord = $request->userId;

        $post = Admin::find($userrecord);
        
        $post->fname = $request->fname;
        $post->email = $request->email;
        $post->phonenumber = $request->phonenumber;
        $post->save();

        return redirect('user-information')->with('success','User Information has been updated successfully');
    }

    public function deleteUser($id)
    {

        $userSession = Session('LoggedUser');
        $userRight = DB::table('Admins')->where('id',$userSession)->value('userRight');

        if($userRight != 10)
        {
            return back()->with('success',"Error, you don't have the right to delete this user");
        }

        $userRecord = Admin::find($id);
        $recordInfoDelete = $userRecord->userRight;

        if($recordInfoDelete == 10)
        {
            return back()->with('success',"Error, Main Admins can not be deleted");
        }

        $userRecord->delete();

        return back()->with('success','UserRecord has been deleted successfully');
    }

    public function activateUser($id)
    {

        $userSession = Session('LoggedUser');
        $userRight = DB::table('Admins')->where('id',$userSession)->value('userRight');

        if($userRight != 10)
        {
            return back()->with('success',"Error, you don't have the right to activate this user");
        }

        $post = Admin::find($id);

        $post->status = 'valid';
        $post->userRight = 1;
        $post->save();

        return back()->with('success',"User Account has been activated successfully");
    }

    public function AddSerie()
    {
        $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        return view('Audio.AddSerie');
    }

    public function storeSerieCreated(Request $request)
    {
        $random_number_reference = rand(10000, 99999);
        $DateCreated = date('y-m-d-H:i:s');

        $SerieId = $DateCreated.''.$random_number_reference;
        $SerieName = $request->serie_name;

        $post = new Serie;

        $post->serieId = $SerieId;
        $post->serieName = $SerieName;
        $post->save();

        return redirect('All-Series')->with('success','New serie has been created successfully');

    }

    public function AllSeries()
    {

        $AllSeries = Serie::all();
        $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        return view('Audio.AllSeries', compact(['AllSeries']));
    }

    public function editSerie($id)
    {

        $serieRecord = Serie::find($id);
        $data=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        return view('Audio.EditSerie', compact(['serieRecord']));
    }

    public function deleteSerie($id)
    {
        
        $serieRecord = Serie::find($id);
        $serieRecord->delete();

        return redirect('All-Series')->with('success','Serie has been deleted successfully');
    }

    public function updateSerieDate(Request $request)
    {

        $post = Serie::find($request->record_id);

        $post->serieName = $request->serie_name;
        $post->save();

        return redirect('All-Series')->with('success','Serie has been updated successfully');
    }
}
