using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsAppFixIT
{
    public partial class FormChangerMDP : Form
    {
        private string connectionString = @"Server=.\SQLEXPRESS;Database=Fixit;Trusted_Connection=True;";
        public string strlogin, strmdp;
        public FormChangerMDP()
        {
            InitializeComponent();
        }

        //enlever le hachage
        public string HacherMotDePasse(string motDePasseClair)
        {
            using (SHA256 moteurSha = SHA256.Create())
            {
                byte[] octetsEntree = Encoding.UTF8.GetBytes(motDePasseClair);
                byte[] octetsHaches = moteurSha.ComputeHash(octetsEntree);
                StringBuilder constructeurChaine = new StringBuilder();
                for (int i = 0; i < octetsHaches.Length; i++)
                {
                    constructeurChaine.Append(octetsHaches[i].ToString("x2"));
                }
                return constructeurChaine.ToString();
            }
        }

        //hacher nouveau mot de passe
        private string GetSha256(string input)
        {
            byte[] inputBytes = Encoding.UTF8.GetBytes(input);
            using (SHA256 sha256 = SHA256.Create())
            {
                byte[] hashBytes = sha256.ComputeHash(inputBytes);
                StringBuilder sb = new StringBuilder();
                foreach (byte b in hashBytes)
                    sb.Append(b.ToString("x2"));
                return sb.ToString();
            }
        }
        private void buttonFermer_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void buttonModifier_Click(object sender, EventArgs e)
        {
            //verification que la personne possede bien le compte 
            this.strlogin = textBoxNom.Text;
            this.strmdp = textBoxAncienMDP.Text;

            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();

            string hashedPassword = HacherMotDePasse(textBoxAncienMDP.Text);

            string sql2 = "select count(*) from LOGIN where Utilisateur = @leroot and PWD = @lwpd";
            SqlCommand cmd = new SqlCommand(sql2, cn);
            cmd.Parameters.AddWithValue("@leroot", textBoxNom.Text);
            cmd.Parameters.AddWithValue("@lwpd", hashedPassword);

            SqlDataReader drcool = cmd.ExecuteReader();

            drcool.Read();
            int nb = drcool.GetInt32(0);
            drcool.Close();

            if (nb == 1)
            {
                //si la connection est bonne :
                string sql = "UPDATE LOGIN SET PWD = @thenewmdp WHERE Utilisateur = @thenom";
                SqlCommand cmd2 = new SqlCommand(sql, cn);
                cmd2.Parameters.AddWithValue("@thenom", textBoxNom.Text);
                string hashbmp = this.GetSha256(textBoxNouveauMDP.Text);
                cmd2.Parameters.AddWithValue("@thenewmdp", hashbmp);
                cmd2.ExecuteNonQuery();
                MessageBox.Show("Le mot de passe a bien été modifié");
                cn.Close();
            }
            else
            {
                MessageBox.Show("Login ou mot de passe incorrect");
                cn.Close();
            }
        }
    }
}
