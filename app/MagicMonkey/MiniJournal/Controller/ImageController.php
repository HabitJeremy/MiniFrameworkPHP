<?php

namespace MagicMonkey\MiniJournal\Controller;

use MagicMonkey\Framework\HttpFoundation\Request;
use MagicMonkey\Framework\HttpFoundation\Response;
use MagicMonkey\Framework\Inheritance\AbstractController;
use MagicMonkey\MiniJournal\RepositoryBd\ImageBd;
use MagicMonkey\MiniJournal\RepositoryForm\ImageForm;
use MagicMonkey\Framework\Tool\FileManager\FileManager;

/**
 * Class ImageController
 * @package MagicMonkey\MiniJournal\Controller
 */
class ImageController extends AbstractController
{
    /**
     * ImageController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Permet d'afficher toutes les images
     * 1) récupère toutes les images
     * 2) affichage
     */
    public function publiees()
    {
        $lstImages = (new ImageBd())->selectAllBy(array('publication_status =' => 'publie'));
        $this->render("image/vAllImages.html.twig", array("endH1" => "publiées", "images" => $lstImages));
    }

    public function nonPubliees()
    {
        if ($this->roleManager->renderAccessDenied($this, array("ROLE_ADMIN", "ROLE_EDITOR"))) {
            $lstImages = (new ImageBd())->selectAllBy(array('publication_status =' => 'brouillon'));
            $this->render("image/vAllImages.html.twig", array("endH1" => "non publiées", "images" => $lstImages));
        }
    }

    /**
     * Permet d'insérer une image
     */
    public function insert()
    {
        if ($this->roleManager->renderAccessDenied($this, array("ROLE_EDITOR", "ROLE_ADMIN"))) {
            $imageForm = new ImageForm();
            $imageeBd = new ImageBd();
            if (count($this->request->getPost()) == 0) { // s'il n'y a pas de données postées
                $this->render("image/vFormNewUpdate.html.twig", array( // affichage du formulaire d'ajout d'une image
                    "title" => "Ajout d'une image",
                    "action" => "insert",
                    "imageForm" => $imageForm
                ));
            } else {
                // récupération et manipulation du file image
                $file = $this->request->getFilesParam("image");
                $fm = new FileManager();
                $infoImg = $file['tmp_name'] ? getimagesize($file['tmp_name']) : false;
                $this->request->addPostParam("file", array($file, $infoImg));
                if ($imageForm->validate($this->request->getPost())) {
                    // verif du formulaire : si aucune erreur
                    $this->request->removePostParam('file');
                    /* upload grâce à l'objet fm FileManager */
                    $this->request->addPostParam("path", $fm->upload($file, DIR_IMAGE));
                    $imageeBd->add($this->request->getPost()); /* enregistrement du nouvel article dans la bdd */
                    $_SESSION['success'] = "Ajout effectué !";
                    header('Location: index.php?a=publiees&o=image'); // redirection vers la liste des images
                    exit();
                } else { // s'il y a au moins une erreur
                    $imageForm->setImage($imageeBd->mapp($this->request->getPost()));
                    // redirection vers le formulaire avec notification
                    $this->render("image/vFormNewUpdate.html.twig", array(
                        "imageForm" => $imageForm,
                        "title" => "Ajout d'une image",
                        "image" => $imageForm->getImage(),
                        "action" => "insert"
                    ));
                }
            }
        }
    }

    /**
     * Permet de supprimer une image
     */
    public function delete()
    {
        if ($this->roleManager->renderAccessDenied($this, array('ROLE_ADMIN', 'ROLE_EDITOR'))) {
            $imageBd = new ImageBd();
            $imageForm = new ImageForm();
            /* stockage de tests dans des variables */
            $isEmptyGetId = !isset($this->request->getGet()['id']);
            $isNotEmptyPostImage = isset($this->request->getPost()['image']);
            /* utilisation des tests */
            if (($isEmptyGetId && $isNotEmptyPostImage) || !$isEmptyGetId) {
                $id = $isEmptyGetId ? $this->request->getPost()['image'] : $this->request->getGet()['id'];
                $image = $imageBd->selectOne(array('id =' => (int)$id));
                if ($image && ($image->getPublicationStatus() == "brouillon") || $this->roleManager->isAuth()) {
                    if ($this->roleManager->renderAuthorDenied($this, $image)) {
                        $imageForm->setImage($imageBd->selectOne(array("id =" => (int)$id)));
                        $res = $imageBd->deleteOne($id);
                        if (!$res && $isNotEmptyPostImage) { // identifiant non renseigné
                            $imageForm->setErrors(array("errorImage" => "L'image doit être indiquée et doit existée"));
                            $this->render("image/vFormSelect.html.twig", array(
                                "images" => $imageBd->selectAll(),
                                "imageForm" => $imageForm,
                                "action" => "delete"
                            ));
                        } else {
                            if (!$res && !$isEmptyGetId) { // l'image n'existe pas
                                $_SESSION['error'] = "Une erreur est survenue lors de la suppression de
                       l'image ! Il se peut que l'image n'existe plus";
                            } else {
                                // suppression du fichier => redirection vers la liste des images
                                $fm = new FileManager();
                                $fm->deleteFile($imageForm->getImage()->getPath(), DIR_IMAGE);
                                $_SESSION['success'] = "Suppression effectuée !";
                            }
                            header('Location: index.php?a=publiees&o=image');
                            exit();
                        }
                    }
                } else {
                    $this->render("image/vCantDeletePublished.html.twig");
                }
            } else { // affichage du formulaire pour choisir une image à supprimer
                $this->render("image/vFormSelect.html.twig", array(
                    "images" => $imageBd->selectAll(),
                    "imageForm" => $imageForm,
                    "action" => "delete"
                ));
            }
        }
    }

    /**
     * Permet d'afficher une image
     */
    public function describe()
    {
        if (isset($this->request->getGet()["id"])) { /* identifiant présent */
            $image = (new ImageBd())->selectOne(array("id =" => (int)$this->request->getGet()['id']));
            if (!$image) { /* image inexistante */
                $_SESSION['error'] = "L'image demandée n'existe pas";
                header('Location: index.php?a=publiees&o=image');
                exit();
            } else { /* image existe */
                $this->render("image/vOneImage.html.twig", array("image" => $image));
            }
        } else { /* identifiant non renseigné */
            $_SESSION['error'] = "Aucune image demandée";
            header('Location: index.php?a=publiees&o=image');
            exit();
        }
    }

    /**
     * Permet de modifier une image
     */
    public function update()
    {
        if ($this->roleManager->renderAccessDenied($this, array('ROLE_ADMIN', 'ROLE_EDITOR'))) {
            $imageBd = new ImageBd();
            $imageForm = new ImageForm();
            if (!isset($this->request->getGet()['id'])) { // id non renseigné
                $_SESSION['error'] = "Aucune image demandée";
                header('Location: index.php?o=image&a=publiees');
                exit();
            } else {
                $imageForm->setImage($imageBd->selectOne(array("id =" => (int)$this->request->getGet()['id']), false));
                if ($this->roleManager->renderAuthorDenied($this, $imageForm->getImage())) {
                    if (count($this->request->getPost()) == 0) { // s'il n'y a pas de données postées
                        if ($imageForm->getImage()) { // si l'image existe => affichage du formulaire de modification
                            $this->render("image/vFormNewUpdate.html.twig", array(
                                "title" => "Modification d'une image",
                                "image" => $imageForm->getImage(),
                                "action" => "update&o=image&id=" . $imageForm->getImage()->getId(),
                                "imageForm" => $imageForm
                            ));
                        } else { // si elle n'existe pas
                            $_SESSION['error'] = "L'image demandée n'existe pas";
                            // redirection => liste des images avec notifications
                            header('Location: index.php?o=image&a=publiees');
                            exit();
                        }
                    } else { // s'il y a des données postées
                        // manipulation du fichier image
                        $file = $this->request->getFilesParam("image");
                        $fm = new FileManager();
                        $infoImg = $file['tmp_name'] ? getimagesize($file['tmp_name']) : true;
                        $this->request->addPostParam("file", array($file, $infoImg));
                        if ($imageForm->validate($this->request->getPost())) { // verif du formulaire : si aucune erreur
                            /* si post file infoImg == true */
                            $test = $this->request->getPostParam('file', false);
                            if (!is_array($test[1])) {
                                /* pas besoin d'upload une nouvelle image */
                                /* add post param 'path' avec l'ancienne valeur soit  $image->getPath()*/
                                $this->request->addPostParam('path', $imageForm->getImage()->getPath());
                            } else { /* sinon */
                                /* on upload gràace à l'objet $fm FileManager */
                                $this->request->addPostParam("path", $fm->upload($file, DIR_IMAGE));
                                /* et on delete l'ancienne */
                                $fm->deleteFile($imageForm->getImage()->getPath(), DIR_IMAGE);
                            }
                            /* on supprime le file post */
                            $this->request->removePostParam('file');
                            /* modification de l'image dans la bdd */
                            $imageBd->update($this->request->getPost(), $imageForm->getImage()->getId());
                            $_SESSION['success'] = "Modification effectuée";
                            header('Location: index.php?o=image&a=describe&id=' . $imageForm->getImage()->getId());
                            exit();
                        } else {
                            // s'il y a au moins une erreur => redirection vers le formulaire de modification avec des
                            // notifications pour aider l'utilisateur
                            $this->request->addPostParam('id', $imageForm->getImage()->getId());
                            $imageForm->setImage($imageBd->mapp($this->request->getPost()));
                            $this->render("image/vFormNewUpdate.html.twig", array(
                                "title" => "Modification d'une image",
                                "image" => $imageForm->getImage(),
                                "action" => "update&o=image&id=" . $imageForm->getImage()->getId(),
                                "imageForm" => $imageForm
                            ));
                        }
                    }
                }
            }
        }
    }
}
