<style>
.demo-wrapper {
    padding: 35px 20px;
    background: #f8f8f8;
    background: rgba(255,255,255,0.3);
    border: 1px solid rgba(0,0,0,0.1);
    border-top-color: rgba(255,255,255,0.4);
    border-bottom-color: rgba(255,255,255,0.4);
}
.block-level {
        width: 200px;
    height: 200px;
    margin: 20px;
    position: relative;
    float: left;
    color: #fff;
    padding: 20px;
    text-shadow: 0 -1px 1px rgba(0,0,0,0.5);
	background-color: #04808E;
}
.block-level a {
    font-size: 18px;
    color: #fff !important;
    text-align: center;
    display: block;
    text-transform: uppercase;
    margin-top: 25px;
}
span.dyno-num {
    display: block;
    font-size: 50px;
    text-shadow: 0px 2px 3px #000000;
}
</style>

<div class="col-md-8 col-sm-9 main_backup dashboard-left-main">
    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-one">
                <p>Total Questions</p>
                <h3><?php echo $questions_count;?></h3>
            </div>
        </div>
            <div class="col-md-4">
            <div class="dashboard-one">
                <p>Registered Users</p>
                <h3><?php echo $users_count['RegUsersCount'];?></h3>
            </div>
        </div>
            <div class="col-md-4">
            <div class="dashboard-one">
                <p>Created Users</p>
                <h3><?php echo $users_count['CreatedUsersCount'];?></h3>
            </div>
        </div>
    </div>
</div>
