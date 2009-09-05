<?php
session_start();

//Kill Switch
if(!isset($_GET['page'])){
	exit();
}

//Include all of the essentials
include_once("./include.php");
include_once("./form.incl.php");
require './libs/Smarty.class.php';


//Smarty Stuff
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("Name", "");


//----------------------------------------------------------------------------------------------------------------------------------//
// PERFORM ALL OF THE AUTHENTICATION
//----------------------------------------------------------------------------------------------------------------------------------//
//Authentication Code
if(isset($_GET['page']) && db_clean_text($_GET['page']) == 'logout'){
	//We are logging out
	unset($_SESSION['attendance_authenticate']);
	$smarty->assign("url","./index.php?page=home");
	$smarty->display('redirect.tpl');
	exit();
}
else if(isset($_SESSION['attendance_authenticate']) && $_SESSION['attendance_authenticate'] == "true"){
	//We are authenticated...
}
else if(isset($_GET['page']) && db_clean_text($_GET['page']) == 'login'){
	//We are trying to authenticate
}
else if(isset($_POST['action']) && db_clean_text($_POST['action']) == 'authenticate'){
	//We are trying to authenticate
	$user = db_clean_text($_POST['uname']);
	$pass = db_clean_text($_POST['passwd']);
	
	//Lets make sure this form is valid
	if(!secureform_test(db_clean_text($_POST['key']), "authenticate")){
		$smarty->assign("url","./index.php?page=login");
		$smarty->display('redirectError.tpl');
		exit();
	}
	//Lets try to authenticate the user
	if(authenticate($user, $pass)){
		$_SESSION['attendance_authenticate'] = "true";
		$smarty->assign("url","./index.php?page=home");
		$smarty->display('redirect.tpl');
		exit();
	}
	//User didn't authenticate!
	else{
		$smarty->assign("url","./index.php?page=login");
		$smarty->display('redirect.tpl');
		exit();
	}
}
else{
	//We are not authenticated and haven't tried to authenticate yet...
	$smarty->assign("url","./index.php?page=login");
	$smarty->display('redirect.tpl');
	exit();
}




//----------------------------------------------------------------------------------------------------------------------------------//
// DETERMINE WHICH PAGE TO RENDER
//----------------------------------------------------------------------------------------------------------------------------------//
switch(db_clean_text($_GET['page'])){
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//PROCESS SUBMITTED DATA
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'process':
	
	
	//Validate the form was valid... This insures that the form request was properly generated
	if(isset($_POST['action'])){
		//We will use these to validate a form
		$verify_key = db_clean_text($_POST['key']);
		$verify_action = db_clean_text($_POST['action']);
		//secureform_test($verify_key, $verify_action)
		//secureform_test_pk($verify_key, $verify_action, $pk)
		
		//PROCESS INDIVIDUAL REQUESTS
		switch(db_clean_text($_POST['action'])){
			
			case 'addSemester': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['semester'] = db_clean_text($_POST['semester']);
			$formData['start_Day'] = db_clean_int($_POST['start_Day']);
			$formData['start_Month'] = db_clean_int($_POST['start_Month']);
			$formData['start_Year'] = db_clean_int($_POST['start_Year']);
			//Verify form
			if(!secureform_test($verify_key, $verify_action)){
				$smarty->assign("url","./index.php?page=addSemester");
				$smarty->display('redirectError.tpl');
				exit();
			}
			addSemester($formData['semester'], $formData['start_Day'], $formData['start_Month'], $formData['start_Year']);
			$smarty->assign("url","./index.php?page=listSemesters");
			$smarty->display('redirect.tpl');
			break;
			
			case 'updateSemester': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['semester'] = db_clean_text($_POST['semester']);
			$formData['start_Day'] = db_clean_int($_POST['start_Day']);
			$formData['start_Month'] = db_clean_int($_POST['start_Month']);
			$formData['start_Year'] = db_clean_int($_POST['start_Year']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateSemester&semester=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			updateSemester($formData['id'], $formData['semester'], $formData['start_Day'], $formData['start_Month'], $formData['start_Year']);
			$smarty->assign("url","./index.php?page=listSemesters");
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteSemester': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateSemester&semester=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			if(retreiveSemesterChildrenCount($formData['id']) == 0){
				//Allowed to be deleted...
				deleteSemester($formData['id']);
			}
			$smarty->assign("url","./index.php?page=listSemesters");
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'addMeeting': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['Date_Day'] = db_clean_int($_POST['Date_Day']);
			$formData['Date_Month'] = db_clean_int($_POST['Date_Month']);
			$formData['Date_Year'] = db_clean_int($_POST['Date_Year']);
			$formData['meeting_type'] = db_clean_int($_POST['meeting_type']);
			$formData['semester'] = db_clean_int($_POST['semester']);
			$formData['description'] = db_clean_text($_POST['description']);
			//Verify form
			if(!secureform_test($verify_key, $verify_action)){
				$smarty->assign("url","./index.php?page=addMeeting&semester=" . $formData['semester']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			addMeeting($formData['Date_Day'], $formData['Date_Month'], $formData['Date_Year'], $formData['meeting_type'], $formData['semester'], $formData['description']);
			$smarty->assign("url","./index.php?page=listMeetings&semester=" . $formData['semester']);
			$smarty->display('redirect.tpl');
			break;
			
			case 'updateMeeting': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['Date_Day'] = db_clean_int($_POST['Date_Day']);
			$formData['Date_Month'] = db_clean_int($_POST['Date_Month']);
			$formData['Date_Year'] = db_clean_int($_POST['Date_Year']);
			$formData['meeting_type'] = db_clean_int($_POST['meeting_type']);
			$formData['semester'] = db_clean_int($_POST['semester']);
			$formData['description'] = db_clean_text($_POST['description']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateMeeting&meeting=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			updateMeeting($formData['id'], $formData['Date_Day'], $formData['Date_Month'], $formData['Date_Year'], $formData['meeting_type'], $formData['semester'], $formData['description']);
			$smarty->assign("url","./index.php?page=listMeetings&semester=" . $formData['semester']);
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteMeeting': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$semester = retreiveSemesterIdForMeeting($formData['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateMeeting&meeting=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			if(retreiveMeetingChildrenCount($formData['id']) == 0){
				//Allowed to be deleted...
				deleteMeeting($formData['id']);
			}
			$smarty->assign("url","./index.php?page=listMeetings&semester=" . $semester);
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'addMember': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['ulink'] = db_clean_text($_POST['ulink']);
			$formData['position'] = db_clean_int($_POST['position']);
			$formData['status'] = db_clean_int($_POST['status']);
			$formData['major'] = db_clean_int($_POST['major']);
			$formData['student_id'] = db_clean_int($_POST['student_id']);
			//Verify form
			if(!secureform_test($verify_key, $verify_action)){
				$smarty->assign("url","./index.php?page=addMember");
				$smarty->display('redirectError.tpl');
				exit();
			}
			addMember($formData['name'], $formData['ulink'], $formData['position'], $formData['status'], $formData['major'], $formData['student_id']);
			if($formData['position'] == 20){
				$smarty->assign("url","./index.php?page=listMembers&inactive=1");
			}
			else{
				$smarty->assign("url","./index.php?page=listMembers");
			}
			$smarty->display('redirect.tpl');
			break;
			
			case 'updateMember': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['ulink'] = db_clean_text($_POST['ulink']);
			$formData['position'] = db_clean_int($_POST['position']);
			$formData['status'] = db_clean_int($_POST['status']);
			$formData['major'] = db_clean_int($_POST['major']);
			$formData['student_id'] = db_clean_int($_POST['student_id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateMember&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			updateMember($formData['id'], $formData['name'], $formData['ulink'], $formData['position'], $formData['status'], $formData['major'], $formData['student_id']);
			if($formData['position'] == 20){
				$smarty->assign("url","./index.php?page=listMembers&inactive=1");
			}
			else{
				$smarty->assign("url","./index.php?page=listMembers");
			}
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'addAttendance': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['member'] = db_clean_int($_POST['member']);
			$formData['meeting'] = db_clean_int($_POST['meeting']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['meeting'])){
				$smarty->assign("url","./index.php?page=addAttendance&meeting=" . $formData['meeting']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			addAttendance($formData['member'], $formData['meeting']);
			$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $formData['meeting']);
			$smarty->display('redirect.tpl');
			break;
			
			case 'updateAttendance': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['position'] = db_clean_int($_POST['position']);
			$formData['status'] = db_clean_int($_POST['status']);
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateAttendance&attendance=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			$meeting = retreiveAttendanceMeetingId($formData['id']);
			updateAttendance($formData['id'], $formData['position'], $formData['status']);
			$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteAttendance': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateAttendance&attendance=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			$meeting = retreiveAttendanceMeetingId($formData['id']);
			deleteAttendance($formData['id']);
			$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'fillAttendanceList': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$meeting = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $meeting)){
				$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
				$smarty->display('redirectError.tpl');
				exit();
			}
			addMembersToAttendance($meeting);
			$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'toggleAttendanceLock': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$meeting = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $meeting)){
				$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
				$smarty->display('redirectError.tpl');
				exit();
			}
			toggleMeetingLock($meeting);
			$smarty->assign("url","./index.php?page=listAttendance&meeting=" . $meeting);
			$smarty->display('redirect.tpl');
			break;
			
			case 'addCommittee': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['description'] = db_clean_text($_POST['description']);
			$formData['manager'] = db_clean_int($_POST['manager']);
			//Verify form
			if(!secureform_test($verify_key, $verify_action)){
				$smarty->assign("url","./index.php?page=addCommittee");
				$smarty->display('redirectError.tpl');
				exit();
			}
			addCommittee($formData['manager'], $formData['name'], $formData['description']);
			$smarty->assign("url","./index.php?page=listCommittees");
			$smarty->display('redirect.tpl');
			break;
			
			case 'updateCommittee': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['description'] = db_clean_text($_POST['description']);
			$formData['manager'] = db_clean_int($_POST['manager']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateCommittee&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			updateCommittee($formData['id'], $formData['manager'], $formData['name'], $formData['description']);
			$smarty->assign("url","./index.php?page=listCommittees");
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteCommittee': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateCommittee&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			deleteCommittee($formData['id']);
			$smarty->assign("url","./index.php?page=listCommittees");
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'addCommitteeMembership': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['member'] = db_clean_int($_POST['member']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listCommitteeMembership&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			addCommitteeMembership($formData['id'], $formData['member']);
			if(isset($_POST['sendBackToMember'])){//If this page was called from the member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . $formData['member'] . "#fragment-4");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listCommitteeMembership&id=" . $formData['id']);
			}
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteCommitteeMembership': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$committee = retreiveCommitteeMembershipCommitteeId($formData['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listCommitteeMembership&id=" . $committee);
				$smarty->display('redirectError.tpl');
				exit();
			}
			deleteCommitteeMembership($formData['id']);
			if(isset($_POST['member'])){//If this page was called from the member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . db_clean_int($_POST['member']) . "#fragment-4");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listCommitteeMembership&id=" . $committee);
			}
			
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'addAchievement': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['category'] = db_clean_int($_POST['category']);
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['image'] = db_clean_text($_POST['image']);
			$formData['description'] = db_clean_text($_POST['description']);
			$formData['goal'] = db_clean_int($_POST['goal']);
			$formData['points'] = db_clean_int($_POST['points']);
			//Verify form
			if(!secureform_test($verify_key, $verify_action)){
				$smarty->assign("url","./index.php?page=addAchievement");
				$smarty->display('redirectError.tpl');
				exit();
			}
			addAchievement($formData['category'], $formData['name'], $formData['image'], $formData['description'], $formData['goal'], $formData['points']);
			$smarty->assign("url","./index.php?page=listAchievements");
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'updateAchievement': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['category'] = db_clean_int($_POST['category']);
			$formData['name'] = db_clean_text($_POST['name']);
			$formData['image'] = db_clean_text($_POST['image']);
			$formData['description'] = db_clean_text($_POST['description']);
			$formData['goal'] = db_clean_int($_POST['goal']);
			$formData['points'] = db_clean_int($_POST['points']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateAchievement&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			updateAchievement($formData['id'], $formData['category'], $formData['name'], $formData['image'], $formData['description'], $formData['goal'], $formData['points']);
			$smarty->assign("url","./index.php?page=listAchievements");
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'deleteAchievement': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateAchievement&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			deleteAchievement($formData['id']);
			$smarty->assign("url","./index.php?page=listAchievements");
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'toggleAchievementLock': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=updateAchievement&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			toggleAchievementLock($formData['id']);
			$smarty->assign("url","./index.php?page=updateAchievement&id=" . $formData['id']);
			$smarty->display('redirect.tpl');
			break;
			
			case 'addAchievementsEarned': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$formData['member'] = db_clean_int($_POST['member']);
			$formData['progress'] = db_clean_int($_POST['progress']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $formData['id']);
				$smarty->display('redirectError.tpl');
				exit();
			}
			addAchievementsEarned($formData['member'], $formData['id'], $formData['progress']);
			if(isset($_POST['sendBackToMember'])){ //Since we arrived from a member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . $formData['member'] . "#fragment-2");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $formData['id']);
			}
			$smarty->display('redirect.tpl');
			break;
			
			case 'deleteAchievementsEarned': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$achievement = retreiveAchievementsEarnedAchievementId($formData['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
				$smarty->display('redirectError.tpl');
				exit();
			}
			deleteAchievementsEarned($formData['id']);
			if(isset($_POST['member'])){//If this page was called from the member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . db_clean_int($_POST['member']) . "#fragment-3");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
			}
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'increaseAchievementsEarned': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$achievement = retreiveAchievementsEarnedAchievementId($formData['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
				$smarty->display('redirectError.tpl');
				exit();
			}
			increaseAchievementsEarnedProgress($formData['id']);
			if(isset($_POST['member'])){//If this page was called from the member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . db_clean_int($_POST['member']) . "#fragment-3");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
			}
			$smarty->display('redirect.tpl');
			break;
			
			
			case 'decreaseAchievementsEarned': //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			$formData['id'] = db_clean_int($_POST['id']);
			$achievement = retreiveAchievementsEarnedAchievementId($formData['id']);
			//Verify form
			if(!secureform_test_pk($verify_key, $verify_action, $formData['id'])){
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
				$smarty->display('redirectError.tpl');
				exit();
			}
			decreaseAchievementsEarnedProgress($formData['id']);
			if(isset($_POST['member'])){//If this page was called from the member's page, send them back there
				$smarty->assign("url","./index.php?page=updateMember&id=" . db_clean_int($_POST['member']) . "#fragment-3");
			}
			else{//This page was called from an achievement page, send them back there
				$smarty->assign("url","./index.php?page=listAchievementsEarned&id=" . $achievement);
			}
			$smarty->display('redirect.tpl');
			break;
			
			
			default: //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			echo "POST:<br />";
			print_r($_POST);
			echo "<br /><br />";
			echo "GET:<br />";
			print_r($_GET);
			break;
		}
	}
	else{
		exit();
	}
	
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD A NEW MEMBER
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addMember':
	$smarty->assign("Name","Add Member");
	if(isset($_GET['inactive']) && db_clean_int($_GET['inactive']) == 1){
		$smarty->assign("inactive", 1);
	}
	else{
		$smarty->assign("inactive", 0);
	}
	$smarty->assign("majors", retreiveMajorValues());
	$smarty->assign("positions", retreivePositionValues());
	$smarty->assign("status", retreiveStatusValues());
	$smarty->display('addMember.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE MEMBER
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateMember':
	$smarty->assign("Name","Update Member");
	$id = db_clean_int($_GET['id']);
	if(isset($_GET['inactive']) && db_clean_int($_GET['inactive']) == 1){
		$smarty->assign("inactive", 1);
	}
	else{
		$smarty->assign("inactive", 0);
	}
	//Member Info
	$member = retreiveMember($id); //Member's information
	$smarty->assign("current_id", $member['id']);
	$smarty->assign("current_name", $member['name']);
	$smarty->assign("current_ulink", $member['ulink']);
	$smarty->assign("current_position", $member['position']);
	$smarty->assign("current_status", $member['status']);
	$smarty->assign("current_major", $member['major']);
	$smarty->assign("current_student_id", $member['student_id']);
	$smarty->assign("majors", retreiveMajorValues());
	$smarty->assign("positions", retreivePositionValues());
	$smarty->assign("status", retreiveStatusValues());
	
	//Achievements
	$smarty->assign("achievements_to_earn", retreiveMembersAchivementsToEarnValues($id));
	$smarty->assign("earned_achievements", retreiveMemberAchievementList($id));
	
	//Committees
	$smarty->assign("committee_membership", retreiveCommitteeMemberToJoin($id));
	
	$smarty->display('updateMember.tpl');
	break;
	
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD MEETING
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addMeeting':
	if(isset($_GET['semester'])){
		$smarty->assign("selected_semester", db_clean_int($_GET['semester']));
	}
	else{
		$smarty->assign("selected_semester", defaultSemester());
	}
	$smarty->assign("meeting_type", retreiveMeetingTypeValues());
	$smarty->assign("semester", retreiveSemesterValues());
	$smarty->display('addMeeting.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE MEETING
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateMeeting':
	$meeting = retreiveMeeting(db_clean_int($_GET['meeting'])); //Member's information
	$smarty->assign("current_id", $meeting['id']);
	$smarty->assign("current_mdate", $meeting['mdate']);
	$smarty->assign("current_meeting_type", $meeting['meeting_type']);
	$smarty->assign("current_semester", $meeting['semester']);
	$smarty->assign("current_description", $meeting['description']);
	$smarty->assign("selected_semester", $meeting['semester']);
	$smarty->assign("children", retreiveMeetingChildrenCount($meeting['id']));
	$smarty->assign("meeting_type", retreiveMeetingTypeValues());
	$smarty->assign("semester", retreiveSemesterValues());
	$smarty->display('updateMeeting.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST MEMBERS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listMembers':
	$smarty->assign("current_quorum", currentQuorum());
	
	if(isset($_GET['inactive']) && db_clean_int($_GET['inactive']) == 1){
		$smarty->assign("inactive", 1);
		$smarty->assign("all_members", retreiveInactiveMembers());
	}
	else{
		$smarty->assign("inactive", 0);
		$smarty->assign("all_members", retreiveActiveMembers());
	}
	$smarty->display('listMembers.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST SEMESTERS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listSemesters':
	$smarty->assign("all_semesters", retreiveSemesters());
	$smarty->display('listSemesters.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD SEMESTER
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addSemester':
	$smarty->assign("semester_choices", array("Spring" => "Spring", "Summer" => "Summer", "Fall" => "Fall"));
	$smarty->assign("semester_selected", "Spring");
	
	$smarty->display('addSemester.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE SEMESTER
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateSemester':
	$semester = db_clean_int($_GET['semester']);
	$semester_info =  retreiveSemester($semester);
	
	$smarty->assign("children", retreiveSemesterChildrenCount($semester));
	$smarty->assign("semester_choices", array("Spring" => "Spring", "Summer" => "Summer", "Fall" => "Fall"));
	$smarty->assign("semester_selected", $semester_info['semester']);
	$smarty->assign("date_selected", $semester_info['startday']);
	$smarty->assign("semester_id", $semester_info['id']);
	
	$smarty->display('updateSemester.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD ATTENDANCE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addAttendance':
	$meeting = db_clean_int($_GET['meeting']);
	$meeting_info = retreiveMeeting($meeting);
	
	$smarty->assign("meeting", $meeting);
	$smarty->assign("member_attendance", retreiveAttendanceMemberValues($meeting));
	
	$smarty->display('addAttendance.tpl');
	break;
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE ATTENDANCE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateAttendance':
	$attendance = db_clean_int($_GET['attendance']);
	$meeting = retreiveAttendanceMeetingId($attendance);
	$smarty->assign("meeting", $meeting);
	$att = retreiveAttendanceRecordWithName($attendance);
	$smarty->assign("attendance_id", $att['id']);
	$smarty->assign("attendance_name", $att['name']);
	$smarty->assign("attendance_position", $att['position']);
	$smarty->assign("attendance_status", $att['status']);
	$smarty->assign("positions", retreivePositionValues());
	$smarty->assign("status", retreiveStatusValues());
	
	$smarty->display('updateAttendance.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST MEETINGS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listMeetings':
	$semester = db_clean_int($_GET['semester']);
	$semesterInfo = retreiveSemester($semester);
	$smarty->assign("semester_id", $semesterInfo["id"]);
	$smarty->assign("semester_year", $semesterInfo["year"]);
	$smarty->assign("semester_semester", $semesterInfo["semester"]);
	$smarty->assign("semester_startday", $semesterInfo["startday"]);
	$smarty->assign("all_meetings", retreiveMeetings($semester));
	$smarty->display('listMeetings.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST ATTENDANCE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listAttendance':
	$meeting = db_clean_int($_GET['meeting']);
	$smarty->assign("meeting_name", retreiveMeetingNameForAttendance($meeting));
	$smarty->assign("meeting_id", $meeting);
	$smarty->assign("semester_id", retreiveSemesterIdForMeeting($meeting));
	$smarty->assign("attendance", retreiveAttendance($meeting));
	$smarty->assign("addable", retreiveAdditionalAttendanceMemberCount($meeting));
	$smarty->assign("meeting_count", retreiveMeetingChildrenCount($meeting));
	$smarty->assign("meeting_lock", retreiveAttendanceMeetingLock($meeting));
	$smarty->display('listAttendance.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ATTENDANCE BLOCK
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'attendanceBlock':
	$attendance = db_clean_int($_GET['attendance']);
	//These are AJAX requests!
	
	//If an update to the attendance record's status is requested, process it.
	//This even validates the key!
	//If it doesn't validate, simply display it as if it wasn't updated, no big deal... just click again.
	if(isset($_GET['status']) && secureform_test_pk(db_clean_text($_GET['key']), "attendanceBlock",$attendance)){ //This also verifies that the request was valid...
		$status = db_clean_int($_GET['status']);
		attendanceUpdateStatus($attendance, $status); //THIS IS THE ONLY UPDATE PERFORMED OUTSIDE OF THE PROCESS BLOCK (REASON: AJAX REQUEST)
	}
	$smarty->assign('attendance', $attendance);
	$smarty->assign('currentStatus', retreiveStatusForMemberAttendanceRecord($attendance));
	
	$smarty->assign("lock", retreiveAttendanceLock($attendance));
	$smarty->display('attendanceBlock.tpl');
	break;
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//QUORUM DETAILS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'quorumDetails':
	$meeting = db_clean_int($_GET['meeting']);
	
	$details = retreiveQuorumDetails($meeting);
	
	$smarty->assign("meeting_id", $meeting);
	
	$smarty->assign('total_members', $details['TotalMembers']);
	$smarty->assign('total_present', $details['TotalPresent']);
	$smarty->assign('voting_members', $details['VotingMembers']);
	$smarty->assign('voting_present', $details['VotingPresent']);
	$smarty->assign('quorum', $details['Quorum']);
	$smarty->assign('quorum_test', $details['QuorumTest']);
	
	$smarty->display('quorumDetails.tpl');
	break;
	
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ACHIEVEMENTTS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listAchievements':
	$smarty->assign("achievements", retreiveAchivements());
	
	$smarty->display('listAchievements.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD ACHIEVEMENTT
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addAchievement':
	$smarty->assign("categories", retreiveAchievementCategoryValues());
	
	$smarty->assign("goal", retreiveAchievementGoalValues());
	$smarty->assign("points", retreiveAchievementPointsValues());
	
	$smarty->display('addAchievement.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE ACHIEVEMENTT
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateAchievement':
	
	$id = db_clean_int($_GET['id']);
	$achievement = retreiveAchievement($id);
	$smarty->assign("achievement_id", $achievement['id']);
	$smarty->assign("achievement_category", $achievement['category']);
	$smarty->assign("achievement_name", $achievement['name']);
	$smarty->assign("achievement_image", $achievement['image']);
	$smarty->assign("achievement_description", $achievement['description']);
	$smarty->assign("achievement_goal", $achievement['goal']);
	$smarty->assign("achievement_points", $achievement['points']);
	$smarty->assign("achievement_added", $achievement['added']);
	$smarty->assign("achievement_lock", $achievement['lock']);
	$smarty->assign("children", retreiveAchievementChildrenCount($id));
	
	$smarty->assign("categories", retreiveAchievementCategoryValues());
	$smarty->assign("goal", retreiveAchievementGoalValues());
	$smarty->assign("points", retreiveAchievementPointsValues());
	$smarty->display('updateAchievement.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ACHIEVEMENTTS
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listAchievementsEarned':
	$id = db_clean_int($_GET['id']);
	$achievement = retreiveAchievement($id);
	$smarty->assign("achievement_id", $achievement['id']);
	$smarty->assign("achievement_name", $achievement['name']);
	$smarty->assign("achievement_goal", $achievement['goal']);
	$smarty->assign("achievement_lock", $achievement['lock']);
	
	$smarty->assign("members", retreiveAchievementsEarned($achievement['id']));
	$smarty->assign("addable_members", retreiveAchievementAddableMemberSelectionValues($achievement['id']));
	$smarty->assign("progress", retreiveAchievementProgressValues($achievement['goal']));
	$smarty->display('listAchievementsEarned.tpl');
	break;
	
	
	
	
	
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ACHIEVEMENTT BLOCK LARGE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'achievementBlockLarge':
	$id = db_clean_int($_GET['id']);
	$achievement = retreiveAchievement($id);
	$smarty->assign("achievement_id", $achievement['id']);
	$smarty->assign("achievement_category", $achievement['category']);
	$smarty->assign("achievement_name", $achievement['name']);
	$smarty->assign("achievement_image", $achievement['image']);
	$smarty->assign("achievement_description", $achievement['description']);
	$smarty->assign("achievement_goal", $achievement['goal']);
	$smarty->assign("achievement_points", $achievement['points']);
	$smarty->assign("achievement_added", $achievement['added']);
	$smarty->assign("achievement_lock", $achievement['lock']);
	$smarty->display('achievementBlockLarge.tpl');
	break;
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ACHIEVEMENT BLOCK MEMBER ADD
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'achievementBlockMemberAdd':
	$smarty->assign("Name", "Add Achievement to Member");
	$id = db_clean_int($_GET['id']);
	$member = db_clean_int($_GET['member']);
	$smarty->assign("member_id", $member);
	$achievement = retreiveAchievement($id);
	$smarty->assign("achievement_id", $achievement['id']);
	$smarty->assign("achievement_category", $achievement['category']);
	$smarty->assign("achievement_name", $achievement['name']);
	$smarty->assign("achievement_image", $achievement['image']);
	$smarty->assign("achievement_description", $achievement['description']);
	$smarty->assign("achievement_goal", $achievement['goal']);
	$smarty->assign("achievement_points", $achievement['points']);
	$smarty->assign("achievement_added", $achievement['added']);
	$smarty->assign("achievement_lock", $achievement['lock']);
	$smarty->assign("progress", retreiveAchievementProgressValues($achievement['goal']));
	$smarty->display('achievementBlockMemberAdd.tpl');
	
	break;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST COMMITTEES
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listCommittees':
	$smarty->assign('committees', retreiveCommittees());
	$smarty->display('listCommittees.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//ADD COMMITTEE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'addCommittee':
	$smarty->assign("member_list", retreiveCommitteeMemberValues());
	$smarty->display('addCommittee.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//UPDATE COMMITTEE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'updateCommittee':
	$id = db_clean_int($_GET['id']);
	
	$committee = retreiveCommittee($id);
		//Information
	$smarty->assign("committee_id", $committee['id']);
	$smarty->assign("committee_manager", $committee['manager']);
	$smarty->assign("committee_name", $committee['name']);
	$smarty->assign("committee_description", $committee['description']);
	$smarty->assign("children", retreiveCommitteeChildrenCount($id));
	$smarty->assign("member_list", retreiveCommitteeMemberValues());
	
	$smarty->display('updateCommittee.tpl');
	break;
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//LIST COMMITTEE MEMBERSHIP
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'listCommitteeMembership':
	$id = db_clean_int($_GET['id']);
	$committee = retreiveCommittee($id);
	$smarty->assign('committee_name', $committee['name']);
	$smarty->assign('committee_id', $committee['id']);
	
	$smarty->assign('membership', retreiveCommitteeMembers($id));
	
	$smarty->assign('addable_members', retreiveCommitteeAddableMemberSelectionValues($id));
	$smarty->display('listCommitteeMembership.tpl');
	break;
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//DEFAULT PAGE
	//----------------------------------------------------------------------------------------------------------------------------------//
	case 'login':
	
	$smarty->display('login.tpl');
	break;
	
	
	//----------------------------------------------------------------------------------------------------------------------------------//
	//DEFAULT PAGE
	//----------------------------------------------------------------------------------------------------------------------------------//
	default:
	$smarty->display('index.tpl');
	break;
}


?>
