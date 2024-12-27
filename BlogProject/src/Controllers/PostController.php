<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Controller;
use App\Models\Category;
use \PDO;

class PostController extends Controller
{
    private $postModel;
    private $categoryModel;
    private $commentModel;

    private $userModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->categoryModel = new Category();
        $this->commentModel = new Comment();
        $this->userModel = new User();
    }

    public function index(){
        $posts = $this->postModel->getRecentPosts();
        $categories = $this->categoryModel->getAllCategory();
        $this->render('home', ['posts' => $posts,'categories' => $categories]);
    }

    public function postList()
    {
        // session_start();
        // if(!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] === null){
        //     header('Location: /user/signin');
        // }
        // Fetch all users and display them in a view
        $posts = $this->postModel->getAllPosts();
        $categories = $this->categoryModel->getAllCategory();
        $recentPosts = $this->postModel->getRecentPosts();
        $this->render('blogs', ['posts' => $posts,'categories' => $categories,'recentPosts'=>$recentPosts]);
    }

    

    public function getPostByCategory($categoryId){
        $posts = $this->postModel->getPostsByCategory($categoryId);
        $categories = $this->categoryModel->getAllCategory();
        $recentPosts = $this->postModel->getRecentPosts();
        $this->render('blogs', ['posts' => $posts,'categories' => $categories,'recentPosts'=>$recentPosts]);
    }

    public function getRecentPost(){
        $posts = $this->postModel->getRecentPosts();
        $categories = $this->categoryModel->getAllCategory();
        $this->render('home', ['posts' => $posts,'categories' => $categories]);
    }


    public function show($postId)
    {

        // session_start();
        // if(!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] === null){
        //     header('Location: /user/signin');
        // }
        // Fetch a single post by ID and display in a view
        $post = $this->postModel->getPostById($postId);
        $postsRecents = $this->postModel->getRecentPosts();
        $categories = $this->categoryModel->getAllCategory();
        $countComments = $this->commentModel->countComment($postId);
        $comments = $this->commentModel->getAllCommentsOfPost($postId);
        $dataComments = [];
        $currentUserId = 4; // TODO: Thay lại bằng userID lấy từ session
        $user = $this->userModel->getUserById($currentUserId);
        foreach ($comments as $comment){
            $subcomments = [];
            $tempSubComments = $this->commentModel->getSubCommentsOfMainComment($comment['postId'], $comment['commentId']);
            foreach ($tempSubComments as $item){
                $subcomments[] = $item;
            }
            $dataComments[] = [
                'mainComment' => $comment, // return 1 dong
                'subComments' => $subcomments, // return []
            ];
        }
        $this->render('postDetail', ['user' => $user, 'post' => $post,'postsRecents' => $postsRecents ,'categories' => $categories,'countComment' => $countComments,'dataComments'=>$dataComments]);

    }

    public function getSearchResult($postNameSearch){
        $resultSearch = $this->postModel->getSearchResult($postNameSearch);
        $categories = $this->categoryModel->getAllCategory();
        $this->render('home', ['resultSearch' => $resultSearch,'categories' => $categories]);
    }

    public function create()
    {
        // session_start();
        // if(!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] === null){
        //     header('Location: /user/signin');
        // }
        // Handle form submission to create a new post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $postName= $_POST['postName'];
            $description= $_POST['description'];
            $categoryId= $_POST['categoryId'];
            $photo = $this->uploadFile();
            $content= $_POST['content'];
            $userId= $_POST['userId'];
            // Call the model to create a new post
            $this->postModel->createPost($postName,$description,$categoryId,$photo,$content,$userId);
        }
        $categories = $this->categoryModel->getAllCategory();
        // $this

        // Display the form to create a new post
        
        $this->render('createPost', ['post' => [],'categories'=>$categories]);
        // header('Location: /');  
    }


    public function uploadFile()
    {
        $target_dir = "assets/images/postImage/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (!file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            // $uploadOk = 0;
            mkdir("assets/images/postImage/", 0777, true);
        }

        // Check file size (limit: 5MB)
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only specific file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if upload is valid
        if ($uploadOk == 0) {
            return false; // File upload failed
        } else {
            // Attempt to upload the file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                return basename($_FILES["fileToUpload"]["name"]); // Return the filename
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }

    public function getPostByUserId(){
        session_start();
        $userId = $_SESSION['currentUser'];
        $posts = $this->postModel->getPostByUserId($userId);
        $this->render('userPostList', ['posts' => $posts]);
    }


    public function update($postId)
    {

        // Handle form submission to update a post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $postName= $_POST['postName'];
            $description= $_POST['description'];
            $categoryId= $_POST['categoryId'];
            $photo = $this->uploadFile();
            $content= $_POST['content'];
            $userId= $_POST['userId'];
            
            // Call the model to update the post
            $this->postModel->updatePost($postId, $postName,$description,$categoryId,$photo,$content,$userId);
        }

        // Fetch the post data and display the form to update
        $post = $this->postModel->getPostById($postId);
        
        $this->render('posts\post-form', ['post' => $post]);
    }

    public function delete($postId)
    {

        // Call the model to delete the post
        $this->postModel->deletePost($postId);

        // Redirect to the index page after deletion
        header('Location: /posts/post-list');
    }
}