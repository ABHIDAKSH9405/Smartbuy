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
    public partial class FormCreationCompte : Form
    {
        private string connectionString = @"Server=.\SQLEXPRESS;Database=Fixit;Trusted_Connection=True;";
        public FormCreationCompte()
        {
            InitializeComponent();
        }

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
        private void label1_Click(object sender, EventArgs e)
        {

        }

        private void FormCreationCompte_Load(object sender, EventArgs e)
        {

        }

        private void buttonFermer_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void buttonCreer_Click(object sender, EventArgs e)
        {
            SqlConnection cn = new SqlConnection(connectionString);
            cn.Open();

            string sqlverif = "SELECT COUNT(*) FROM LOGIN WHERE Utilisateur = @thenom";
            SqlCommand cmd2 = new SqlCommand(sqlverif, cn);
            cmd2.Parameters.AddWithValue("@thenom", textBoxNom.Text);
            int count = (int)cmd2.ExecuteScalar();
            if (count == 0)
            { 
                string sql = "INSERT INTO LOGIN VALUES(@thenom, @themdp)";
                SqlCommand cmd = new SqlCommand(sql, cn);
                cmd.Parameters.AddWithValue("@thenom", textBoxNom.Text);
                string hashbmp = this.GetSha256(textBoxMDP.Text);
                cmd.Parameters.AddWithValue("@themdp", hashbmp);

                cmd.ExecuteNonQuery();
                MessageBox.Show("Le compte a bien été crée");
                this.Close();
            }
            else
            {
                MessageBox.Show("Le Nom d'utilisateur existe déja");
            }
        }
    }
}
