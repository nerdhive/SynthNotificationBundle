<?php
namespace Synth\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Synth\NotificationBundle\Entity\NotificationManager;

class NotificationController extends Controller
{

	/**
     * 
     * @return NotificationManager
     */
    protected function getNotificationManager()
    {
        return $this->container->get('synth_notification.notification_manager.default');
    }

    public function markNotificationAsReadAction(Request $request)
    {
        $id = $request->get('notificationId', null);
        $notFound = true;

        if ($id !== null) {
            $notification = $this->getNotificationManager()->findNotificationByForUser($this->getUser(), array('id' => $id));
            if ($notification !== null) {
                $this->getNotificationManager()->markNotificationAsRead($notification);
                $notFound = false;
            }
        }

        if ($notFound) {
            throw $this->createNotFoundException();
        } else {
            return new JsonResponse();
        }
    }

    public function markNotificationsAsReadAction()
    {
        $this->getNotificationManager()->markNotificationsAsRead($this->getUser());

        return new JsonResponse();
    }

    public function deleteNotificationAction(Request $request)
    {
        $id = $request->get('notificationId', null);
        $accessDenied = true;

        if ($id !== null) {
            $notification = $this->getNotificationManager()->findNotificationByForUser($this->getUser(), array('id' => $id));
            if ($notification !== null) {
                $this->getNotificationManager()->deleteNotification($notification);
                $accessDenied = false;
            }
        }

        if ($accessDenied) {
            throw $this->createAccessDeniedException();
        } else {
            return new JsonResponse();
        }
    }

    public function deleteNotificationsAction()
    {
        $notifications = $this->getNotificationManager()->findNotificationsForUser($this->getUser());
        $this->getNotificationManager()->deleteNotifications($notifications);

        return new JsonResponse();
    }

	public function listAction(Request $request)
	{
		$notifications = $this->getNotificationManager()->findNotificationsForUser($this->getUser());

		return $this->render('SynthNotificationBundle:notification:list.html.twig', array(
				'notifications' => $notifications
			));
	}
}